<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\Log;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Http\Request;
// Log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Peminjaman::syncAllActivePeminjaman();

        $stats = [
            'menunggu' => Peminjaman::where('status', 'menunggu')->count(),
            'dipinjam' => Peminjaman::whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat'])->count(),
            'total_peminjaman' => Peminjaman::count(),
            'total_alat' => DetailPeminjaman::whereHas('peminjaman', function ($query) {
                $query->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat']);
            })->sum('jumlah'),
        ];

        // filter menunggu
        $searchMenunggu = $request->input('search_menunggu');
        $durasiMenunggu = $request->input('durasi_menunggu');

        // filter aktif
        $searchAktif = $request->input('search_aktif');
        $durasiAktif = $request->input('durasi_aktif');
        $statusAktif = $request->input('status_aktif');

        // filter riwayat
        $searchRiwayat = $request->input('search_riwayat');
        $durasiRiwayat = $request->input('durasi_riwayat');
        $statusRiwayat = $request->input('status_riwayat');

        // durasi list untuk dropdown filter
        $durasiList = Alat::whereNotNull('durasi')
            ->select('durasi')
            ->distinct()
            ->orderBy('durasi')
            ->pluck('durasi');

        // query search untuk menunggu
        $menunggu = Peminjaman::with('peminjam', 'petugas', 'detailPeminjaman.alat.kategori')
            ->where('status', 'menunggu')
            ->when($searchMenunggu, function ($q) use ($searchMenunggu) {
                $q->where(function ($query) use ($searchMenunggu) {
                    $query->where('kode_peminjaman', 'like', "%{$searchMenunggu}%")
                        ->orWhereHas('peminjam', fn($q2) => $q2->where('nama_lengkap', 'like', "%{$searchMenunggu}%"));
                });
            })
            ->when($durasiMenunggu, function ($q) use ($durasiMenunggu) {
                $q->whereHas('detailPeminjaman.alat', fn($q2) => $q2->where('durasi', $durasiMenunggu));
            })
            ->latest()
            ->paginate(3, ['*'], 'page_menunggu');

        // query search untuk section peminjaman aktif
        $dipinjam = Peminjaman::with('peminjam', 'petugas', 'detailPeminjaman.alat.kategori')
            ->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat'])  // ← PASTIKAN INI
            ->when($searchAktif, function ($q) use ($searchAktif) {
                $q->where(function ($query) use ($searchAktif) {
                    $query->where('kode_peminjaman', 'like', "%{$searchAktif}%")
                        ->orWhereHas('peminjam', fn($q2) => $q2->where('nama_lengkap', 'like', "%{$searchAktif}%"));
                });
            })
            ->when($durasiAktif, function ($q) use ($durasiAktif) {
                $q->whereHas('detailPeminjaman.alat', fn($q2) => $q2->where('durasi', $durasiAktif));
            })
            ->when($statusAktif, fn($q) => $q->where('status', $statusAktif))
            ->latest()
            ->paginate(3, ['*'], 'page_aktif');

        // query untuk riwayat dengan filter
        $riwayat = Peminjaman::with('peminjam', 'petugas', 'detailPeminjaman.alat.kategori')
            ->whereIn('status', ['selesai', 'ditolak'])
            ->when($searchRiwayat, function ($q) use ($searchRiwayat) {
                $q->where(function ($query) use ($searchRiwayat) {
                    $query->where('kode_peminjaman', 'like', "%{$searchRiwayat}%")
                        ->orWhereHas('peminjam', fn($q2) => $q2->where('nama_lengkap', 'like', "%{$searchRiwayat}%"));
                });
            })
            ->when($durasiRiwayat, function ($q) use ($durasiRiwayat) {
                $q->whereHas('detailPeminjaman.alat', fn($q2) => $q2->where('durasi', $durasiRiwayat));
            })
            ->when($statusRiwayat, fn($q) => $q->where('status', $statusRiwayat))
            ->latest()
            ->paginate(4, ['*'], 'page_riwayat');

        return view('admin.peminjaman.index', compact(
            'dipinjam',
            'menunggu',
            'riwayat',
            'stats',
            'durasiList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return ke view create
        // ambil semua user yang bisa jadi peminjam
        $peminjam = Pengguna::where('role', 'peminjam')->get();
        $petugas = Pengguna::where('role', 'petugas')->get();

        // ambil semua alat yang tersedia
        $alat = Alat::with('kategori')->get();

        // select alat alat dengan durasi yang sama
        $durasiList = Alat::select('durasi')->whereNotNull('durasi')->distinct()->orderBy('durasi')->pluck('durasi');

        return view('admin.peminjaman.create', compact('peminjam', 'petugas', 'alat', 'durasiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'peminjam_id' => 'required|exists:user,id',
            'petugas_id' => in_array($request->status, ['dipinjam', 'selesai'])
                ? 'required|exists:user,id'
                : 'nullable',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_disetujui' => 'nullable|date',
            'durasi' => 'required|integer|exists:alat,durasi',
            'status' => 'required|in:menunggu,dipinjam,selesai,ditolak',
            'items' => 'required|array|min:1',
            'items.*.alat_id' => 'required|exists:alat,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'tanggal_disetujui.after_or_equal' => 'Waktu (jam/menit) atau tanggal disetujui tidak boleh mendahului waktu pengajuan!',
        ]);

        // handle biar alat ga duplikat masukinnya sama si admin (never trust user input) gelok
        $alatIds = collect($validated['items'])->pluck('alat_id');
        if ($alatIds->duplicates()->isNotEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'items' => 'Alat tidak boleh duplikat.',
                ]);
        }

        // begitu juga dengan status dipnjkam yak
        if (
            in_array($validated['status'], [
                'dipinjam',
                'selesai',
            ])
        ) {
            $petugas = Pengguna::find($validated['petugas_id']);

            if (!$petugas || $petugas->role !== 'petugas') {

                return back()->withErrors([
                    'petugas_id' => 'User bukan petugas.',
                ]);
            }
        }

        // validasi tambahan biar cuma peminjam aja yang boleh minjam
        $peminjam = Pengguna::find($validated['peminjam_id']);
        if (!$peminjam || $peminjam->role !== 'peminjam') {
            return back()
                ->withInput()
                ->withErrors([
                    'peminjam_id' => 'User bukan peminjam.',
                ]);
        }

        // validasi kalau satu peminjaman harus memiliki 1 durasi alat alat yang sama
        foreach ($validated['items'] as $item) {
            $alat = Alat::find($item['alat_id']);

            if ($alat->durasi != $validated['durasi']) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'durasi' => 'Semua alat harus memiliki durasi yang sama.',
                    ]);
            }
        }

        // helper untuk store
        $statusPinjamAktif = in_array($validated['status'], [
            'dipinjam',
            'jatuh_tempo',
            'terlambat',
        ]);

        $statusPunyaDeadline = in_array($validated['status'], [
            'dipinjam',
            'selesai',
        ]);

        $tanggal_disetujui = $statusPunyaDeadline ? now() : null;

        // ambil durasi yang sudah tervalidasi
        $durasi = (int) $validated['durasi'];

        $deadline = null;

        if ($statusPunyaDeadline) {
            $deadline = Carbon::parse($tanggal_disetujui)->addMinutes($durasi);
        }
        DB::beginTransaction();

        try {

            // simpan peminjaman utama
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $this->generateKodePeminjaman(),
                'peminjam_id' => $validated['peminjam_id'],
                'petugas_id' => $validated['petugas_id'] ?? null,
                'status' => $validated['status'],
                'durasi' => in_array($validated['status'], [
                    'dipinjam',
                    'selesai',
                ])
                    ? $durasi
                    : null,
                'deadline' => $deadline,
                'tanggal_pengajuan' => $validated['tanggal_pengajuan'],
                'tanggal_disetujui' => in_array($validated['status'], [
                    'dipinjam',
                    'selesai',
                ])
                    ? $tanggal_disetujui // <--- Ganti di bagian ini saja
                    : null,
            ]);

            // loop alat
            foreach ($validated['items'] as $item) {
                $alat = Alat::lockForUpdate()->findOrFail($item['alat_id']);

                // cek stok hanya jika langsung dipinjam
                if ($statusPinjamAktif && $item['jumlah'] > $alat->stok) {

                    Log::create([
                        'user_id' => Auth::id(),
                        'role' => Auth::user()->role,
                        'modul' => 'peminjaman',
                        'aksi' => 'create',
                        'target' => $alat->nama_alat,
                        'keterangan' => 'Gagal membuat peminjaman karena stok tidak mencukupi.',
                        'status' => 'error',
                    ]);

                    DB::rollBack();

                    return back()
                        ->withInput()
                        ->withErrors([
                            'stok' => 'Stok alat "' . $alat->nama_alat . '" tidak mencukupi.',
                        ]);
                }

                // simpan detail
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alat->id,
                    'jumlah' => $item['jumlah'],
                ]);

                // kurangi stok hanya jika langsung dipinjam
                if ($statusPinjamAktif) {

                    $alat->decrement('stok', $item['jumlah']);
                }
            }

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'peminjaman',
                'aksi' => 'create',
                'target' => $peminjaman->kode_peminjaman,
                'keterangan' => match ($validated['status']) {
                    'menunggu' => 'Admin membuat pengajuan peminjaman baru.',
                    'dipinjam' => 'Admin langsung menyetujui peminjaman.',
                    'selesai' => 'Admin membuat peminjaman selesai.',
                    'ditolak' => 'Admin membuat data peminjaman ditolak.',
                    default => 'Admin membuat peminjaman.',
                },
                'status' => 'success',
            ]);

            DB::commit();

            return redirect()
                ->route('admin-peminjaman')
                ->with('success', 'Peminjaman berhasil ditambahkan.');

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        $peminjam = Pengguna::where('role', 'peminjam')->get();
        $petugas = Pengguna::where('role', 'petugas')->get();

        $alat = Alat::with('kategori')->get();

        $durasiList = Alat::whereNotNull('durasi')
            ->select('durasi')
            ->distinct()
            ->orderBy('durasi')
            ->pluck('durasi');

        $peminjaman->load('detailPeminjaman');

        return view('admin.peminjaman.edit', compact('peminjaman', 'peminjam', 'petugas', 'alat', 'durasiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // validasi
        $validated = $request->validate([
            'peminjam_id' => 'required|exists:user,id',
            'petugas_id' => in_array($request->status, [
                'dipinjam',
                'selesai',
                'ditolak',
            ])
                ? 'required|exists:user,id'
                : 'nullable',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_disetujui' => 'nullable|date',
            'status' => 'required|in:menunggu,dipinjam,selesai,ditolak',
            'items' => 'required|array|min:1',
            'items.*.alat_id' => 'required|exists:alat,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'tanggal_disetujui.after_or_equal' => 'Waktu (jam/menit) atau tanggal disetujui tidak boleh mendahului waktu pengajuan!',
        ]);

        // validasi semua durasi alat harus sama lo ya >:(
        $durasiAlat = Alat::whereIn('id', collect($validated['items'])->pluck('alat_id'))->pluck('durasi')->unique();
        if ($durasiAlat->count() > 1) {

            return back()
                ->withInput()
                ->withErrors([
                    'durasi' => 'Semua alat harus memiliki durasi yang sama.',
                ]);
        }
        $durasi = $durasiAlat->first();
        if (is_null($durasi)) {
            return back()
                ->withInput()
                ->withErrors([
                    'durasi' => 'Semua alat wajib memiliki durasi.',
                ]);
        }

        // cek kalau bener bener peminjam
        $peminjam = Pengguna::find($validated['peminjam_id']);
        if ($peminjam->role !== 'peminjam') {
            return back()->withErrors([
                'peminjam_id' => 'User bukan peminjam.',
            ]);
        }

        // cek kalau lu tuh petugas kocak
        if (isset($validated['petugas_id'])) {
            $petugas = Pengguna::find($validated['petugas_id']);

            if (!$petugas || $petugas->role !== 'petugas') {
                return back()->withErrors([
                    'petugas_id' => 'User bukan petugas.',
                ]);
            }
        }

        // anti duplicate alat
        $alatIds = collect($validated['items'])->pluck('alat_id');

        if ($alatIds->duplicates()->isNotEmpty()) {

            return back()
                ->withInput()
                ->withErrors([
                    'items' => 'Alat tidak boleh duplikat.',
                ]);
        }

        DB::beginTransaction();

        $peminjaman = Peminjaman::lockForUpdate()->findOrFail($peminjaman->id);

        $statusLama = $peminjaman->status;
        $statusBaru = $validated['status'];

        $baruDisetujui = $validated['status'] == 'dipinjam' && $statusLama != 'dipinjam';

        $tanggal_disetujui = $baruDisetujui
            ? now()
            : $peminjaman->tanggal_disetujui;

        // helper untuk update
        $statusPinjamAktif = in_array($validated['status'], [
            'dipinjam',
            'jatuh_tempo',
            'terlambat',
        ]);

        $statusLamaAktif = in_array($statusLama, [
            'dipinjam',
            'jatuh_tempo',
            'terlambat',
        ]);

        $peminjaman->load([
            'detailPeminjaman.alat',
            'detailPeminjaman.detailPengembalian',
        ]);

        try {
            // detail lama di hapus - begitu juga detail detail lainnya
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->detailPengembalian()->exists()) {

                    DB::rollBack();

                    return back()
                        ->withInput()
                        ->withErrors([
                            'items' => 'Peminjaman yang sudah memiliki data pengembalian tidak dapat diubah.',
                        ]);
                }
            }

            // karena logic update juga mempermainkan stok alat
            // balikkan stok lama terlebih dahulu sebelum commit
            foreach ($peminjaman->detailPeminjaman as $detailLama) {
                $alatLama = Alat::withTrashed()->lockForUpdate()->find($detailLama->alat_id);

                if (!$alatLama) {
                    throw new \Exception('Alat lama tidak ditemukan.');
                }

                // kalau stok di detail dikurangi, tambahin lagi stoknya di tabel alat
                if ($statusLamaAktif) {
                    $alatLama->increment(
                        'stok',
                        $detailLama->jumlah
                    );
                }
            }

            $deadline = null;
            if ($statusPinjamAktif) {
                $deadline = Carbon::parse($tanggal_disetujui)->addMinutes($durasi);
            }

            // update data peminjaman
            $peminjaman->update([
                'peminjam_id' => $validated['peminjam_id'],
                'petugas_id' => in_array($validated['status'], [
                    'dipinjam',
                    'selesai',
                    'ditolak',
                ])
                    ? $validated['petugas_id']
                    : null,
                'status' => $validated['status'],
                'durasi' => $validated['status'] == 'dipinjam'
                    ? $durasi
                    : null,
                'deadline' => $deadline,
                'tanggal_pengajuan' => $validated['tanggal_pengajuan'],
                'tanggal_disetujui' => in_array($validated['status'], [
                    'dipinjam',
                    'selesai',
                    'ditolak',
                ])
                    ? $tanggal_disetujui // <--- Ubah bagian ini saja
                    : null,
            ]);

            $peminjaman->detailPeminjaman()->delete();

            // nah baru bikin ulan detail_peminjaman yang barui untuk peminjaman tersebut
            foreach ($validated['items'] as $item) {

                $alat = Alat::lockForUpdate()->findOrFail($item['alat_id']);

                // cek stok
                if ($validated['status'] == 'dipinjam' && $item['jumlah'] > $alat->stok) {

                    Log::create([
                        'user_id' => Auth::id(),
                        'role' => Auth::user()->role,
                        'modul' => 'peminjaman',
                        'aksi' => 'update',
                        'target' => $alat->nama_alat,
                        'keterangan' => 'Gagal memperbarui peminjaman karena stok tidak cukup.',
                        'status' => 'error',
                    ]);

                    DB::rollBack();

                    return back()
                        ->withInput()
                        ->withErrors([
                            'stok' => 'Stok alat "' . $alat->nama_alat . '" tidak mencukupi.',
                        ]);
                }

                // create detail baru
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alat->id,
                    'jumlah' => $item['jumlah'],
                ]);

                // kurangi stok lagi kalau di detail pimnjaman nambah stok
                if ($statusPinjamAktif) {

                    $updated = Alat::where('id', $alat->id)
                        ->where('stok', '>=', $item['jumlah'])
                        ->decrement('stok', $item['jumlah']);

                    if (!$updated) {

                        DB::rollBack();

                        return back()
                            ->withErrors([
                                'stok' => 'Stok tidak mencukupi.',
                            ]);
                    }
                }
            }

            // jenis aksi
            $aksiLog = match (true) {
                $statusLama === 'menunggu' && $statusBaru === 'dipinjam' => 'approve',
                $statusBaru === 'ditolak' => 'reject',
                default => 'update',
            };

            // ket. log
            $keteranganLog = match ($aksiLog) {
                'approve' => 'Admin menyetujui peminjaman.',
                'reject' => 'Admin menolak peminjaman.',
                default => 'Admin memperbarui data peminjaman.',
            };

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'peminjaman',
                'aksi' => $aksiLog,
                'target' => $peminjaman->kode_peminjaman,
                'keterangan' => $keteranganLog,
                'status' => $aksiLog === 'reject'
                    ? 'warning'
                    : 'success',
            ]);

            DB::commit();

            return redirect()
                ->route('admin-peminjaman')
                ->with('success', 'Peminjaman berhasil diperbarui.');

        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        DB::beginTransaction();

        try {
            $peminjaman->load('detailPeminjaman.detailPengembalian');

            // cek tetangga (tabel pengembalian dan detail pengembalian)
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->detailPengembalian()->exists()) {

                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Hapus data pengembalian terkait terlebih dahulu sebelum menghapus peminjaman ini.'
                    );
                }
            }

            // kembalikan stok HANYA jika peminjaman sedang aktif
            if (
                in_array($peminjaman->status, [
                    'dipinjam',
                    'jatuh_tempo',
                    'terlambat',
                ])
            ) {
                foreach ($peminjaman->detailPeminjaman as $detail) {

                    Alat::where('id', $detail->alat_id)
                        ->increment('stok', $detail->jumlah);
                }
            }

            // for prevent alur delete yang ambigu
            $peminjaman->detailPeminjaman()->delete();
            $peminjaman->delete();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'peminjaman',
                'aksi' => 'delete',
                'target' => $peminjaman->kode_peminjaman,
                'keterangan' => 'Admin menghapus data peminjaman.',
                'status' => 'warning',
            ]);

            DB::commit();

            $pesan = 'Data peminjaman berhasil dihapus.';

            return redirect()
                ->route('admin-peminjaman')
                ->with('success', $pesan);

        } catch (\Throwable $th) {
            DB::rollBack();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'peminjaman',
                'aksi' => 'delete',
                'target' => $peminjaman->kode_peminjaman,
                'keterangan' => 'Gagal menghapus peminjaman karena memiliki data pengembalian.',
                'status' => 'warning',
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    private function generateKodePeminjaman()
    {
        // ambil 2 digit tahun
        $tahun = now()->format('y');

        // ambil bulan
        $bulan = now()->format('m');

        // prefix kode
        $prefix = "INV-PJ-{$tahun}{$bulan}-";

        // cari kode terakhir bulan ini
        $lastPeminjaman = Peminjaman::where('kode_peminjaman', 'like', $prefix . '%')
            ->latest('id')
            ->first();

        // default nomor
        $nomor = 1;

        // kalau ada transaksi sebelumnya
        if ($lastPeminjaman) {

            // ambil 3 digit terakhir
            $lastNumber = substr($lastPeminjaman->kode_peminjaman, -3);

            // increment
            $nomor = intval($lastNumber) + 1;
        }

        // format jadi 3 digit
        $nomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);

        // hasil akhir
        return $prefix . $nomor;
    }
}
