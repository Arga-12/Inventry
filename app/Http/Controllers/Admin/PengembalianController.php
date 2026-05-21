<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPengembalian;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
// Log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // filter menunggu verifikasi
        $searchMenunggu = $request->input('search_menunggu');
        $durasiMenunggu = $request->input('durasi_menunggu');

        // filter selesai
        $searchSelesai = $request->input('search_selesai');
        $durasiSelesai = $request->input('durasi_selesai');
        $kondisiSelesai = $request->input('kondisi_selesai');

        // durasi list untuk dropdown filter
        $durasiList = Alat::whereNotNull('durasi')
            ->select('durasi')
            ->distinct()
            ->orderBy('durasi')
            ->pluck('durasi');

        // tampilan untuk statistik
        $stats = [
            'menunggu_verifikasi' => Pengembalian::where('status', 'menunggu_verifikasi')->count(),
            'selesai' => Pengembalian::where('status', 'selesai')->count(),
            'total_item_menunggu' => DetailPengembalian::whereHas('pengembalian', function ($query) {
                $query->where('status', 'menunggu_verifikasi');
            })->sum('jumlah_kembali'),
            'total_kategori_selesai' => Kategori::whereHas(
                'alat.detailPeminjaman.detailPengembalian.pengembalian',
                function ($query) {
                    $query->where('status', 'selesai');
                }
            )->count(),
        ];

        // query untuk menunggu verifikasi
        $menunggu = Pengembalian::with([
            'peminjaman.peminjam',
            'detailPengembalian.detailPeminjaman.alat.kategori',
        ])
            ->where('status', 'menunggu_verifikasi')
            ->when($searchMenunggu, function ($q) use ($searchMenunggu) {
                $q->where(function ($query) use ($searchMenunggu) {
                    $query->where('kode_pengembalian', 'like', "%{$searchMenunggu}%")
                        ->orWhereHas('peminjaman.peminjam', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$searchMenunggu}%"));
                });
            })
            ->when($durasiMenunggu, function ($q) use ($durasiMenunggu) {
                $q->whereHas('peminjaman.detailPeminjaman.alat', fn ($q2) => $q2->where('durasi', $durasiMenunggu));
            })
            ->latest()
            ->get();

        // query untuk selesai
        $selesai = Pengembalian::with([
            'peminjaman.peminjam',
            'detailPengembalian.detailPeminjaman.alat.kategori',
        ])
            ->where('status', 'selesai')
            ->when($searchSelesai, function ($q) use ($searchSelesai) {
                $q->where(function ($query) use ($searchSelesai) {
                    $query->where('kode_pengembalian', 'like', "%{$searchSelesai}%")
                        ->orWhereHas('peminjaman.peminjam', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$searchSelesai}%"));
                });
            })
            ->when($durasiSelesai, function ($q) use ($durasiSelesai) {
                $q->whereHas('peminjaman.detailPeminjaman.alat', fn ($q2) => $q2->where('durasi', $durasiSelesai));
            })
            ->when($kondisiSelesai, function ($q) use ($kondisiSelesai) {
                $q->whereHas('detailPengembalian', function ($query) use ($kondisiSelesai) {
                    $query->where('kondisi', $kondisiSelesai);
                });
            })
            ->latest()
            ->get();

        return view('admin.pengembalian.index', compact('menunggu', 'selesai', 'stats', 'durasiList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Peminjaman::syncAllActivePeminjaman();

        $peminjaman = Peminjaman::with([
            'peminjam',
            'detailPeminjaman.alat.kategori',
            'pengembalian',
        ])
            ->whereIn('status', [
                'jatuh_tempo',
                'terlambat',
            ])

        // cegah yang sudah punya pengembalian
            ->whereDoesntHave('pengembalian')
            ->latest()
            ->get();

        return view('admin.pengembalian.create', compact('peminjaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi
        $valid = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'status' => 'required|in:menunggu_verifikasi,selesai',
            'tanggal_pengembalian' => 'required|date',
            'tanggal_verifikasi' => $request->status === 'selesai'
                ? 'required|date|after_or_equal:tanggal_pengembalian'
                : 'nullable|date',
            'items' => $request->status === 'selesai'
                ? 'required|array|min:1'
                : 'nullable|array',
            'items.*.detail_peminjaman_id' => 'required_with:items|exists:detail_peminjaman,id',
            'items.*.kondisi' => 'required_with:items|in:lolos,rusak',
            'items.*.catatan_kondisi' => 'nullable|string',
        ], [
            'tanggal_verifikasi.after_or_equal' => 'Tanggal verifikasi tidak boleh mendahului tanggal pengembalian.',
        ]);

        DB::beginTransaction();

        try {

            // lock peminjaman biar aman dari race condition
            $peminjaman = Peminjaman::lockForUpdate()
                ->with([
                    'pengembalian',
                    'detailPeminjaman.alat',
                ])
                ->findOrFail($valid['peminjaman_id']);

            // hanya boleh dari status jatuh tempo / terlambat
            if (! in_array($peminjaman->status, [
                'jatuh_tempo',
                'terlambat',
            ])) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'peminjaman_id' => 'Peminjaman belum dapat dikembalikan.',
                    ]);
            }

            // cegah duplicate pengembalian
            if ($peminjaman->pengembalian()->exists()) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'peminjaman_id' => 'Pengembalian untuk peminjaman ini sudah dibuat.',
                    ]);
            }

            if (Carbon::parse($valid['tanggal_pengembalian'])->startOfDay()->lt(
                Carbon::parse($peminjaman->tanggal_disetujui)->startOfDay()
            )) {
                DB::rollBack();

                return back()->withErrors([
                    'tanggal_pengembalian' => 'Tanggal pengembalian tidak boleh lebih awal dari tanggal peminjaman ('.
                        Carbon::parse($peminjaman->tanggal_disetujui)->format('d-m-Y').').',
                ]);
            }

            // validasi Tidak boleh lebih awal dari deadline (opsional)
            if (Carbon::parse($valid['tanggal_pengembalian'])->lt($peminjaman->deadline)) {
                DB::rollBack();

                return back()->withErrors([
                    'tanggal_pengembalian' => 'Tanggal pengembalian tidak boleh lebih awal dari deadline peminjaman.',
                ]);
            }

            // wajib punya detail peminjaman
            if ($peminjaman->detailPeminjaman->isEmpty()) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'peminjaman_id' => 'Detail peminjaman tidak ditemukan.',
                    ]);
            }

            // kalau selesai, stok langunsg go back
            $langsungSelesai = $valid['status'] === 'selesai';

            // create pengembalian
            $pengembalian = Pengembalian::create([
                'kode_pengembalian' => $this->generateKodePengembalian(),
                'peminjaman_id' => $peminjaman->id,
                'petugas_id' => Auth::id(),
                'status' => $valid['status'],
                'tanggal_pengembalian' => $valid['tanggal_pengembalian'],
                'tanggal_verifikasi' => $langsungSelesai
                    ? $valid['tanggal_verifikasi']
                    : null,
            ]);

            // copy semua detail peminjaman
            foreach ($peminjaman->detailPeminjaman as $detail) {

                $inputItem = collect($valid['items'] ?? [])
                    ->firstWhere(
                        'detail_peminjaman_id',
                        $detail->id
                    );

                $kondisi = $langsungSelesai
                    ? ($inputItem['kondisi'] ?? 'lolos')
                    : 'menunggu_verifikasi';

                $catatan = $langsungSelesai
                    ? ($inputItem['catatan_kondisi'] ?? null)
                    : null;

                DetailPengembalian::create([
                    'pengembalian_id' => $pengembalian->id,
                    'detail_peminjaman_id' => $detail->id,
                    'jumlah_kembali' => $detail->jumlah,
                    'kondisi' => $kondisi,
                    'catatan_kondisi' => $catatan,
                ]);

                // stok hanya kembali jika lolos
                if ($langsungSelesai && $kondisi === 'lolos') {

                    $detail->alat->increment(
                        'stok',
                        $detail->jumlah
                    );
                }
            }

            // dan terakhir, ubah peminjaman yang lagi ke link di jadi selesai
            $peminjaman->update([
                'status' => 'selesai',
            ]);

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'create',
                'target' => $pengembalian->kode_pengembalian,
                'keterangan' => 'Membuat pengembalian untuk peminjaman '.$peminjaman->kode_peminjaman,
                'status' => 'success',
            ]);

            DB::commit();

            return redirect()
                ->route('admin-pengembalian')
                ->with(
                    'success',
                    'Pengembalian berhasil dibuat dan menunggu verifikasi.'
                );

        } catch (\Throwable $th) {

            DB::rollBack();

            dd($th->getMessage());

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat membuat pengembalian.'
                );
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
    public function edit(Pengembalian $pengembalian)
    {
        $peminjaman = Peminjaman::with([
            'peminjam',
            'detailPeminjaman.alat.kategori',
        ])
            ->whereIn('status', ['jatuh_tempo', 'terlambat'])
            ->orWhere('id', $pengembalian->peminjaman_id)
            ->get();

        $pengembalian->load([
            'peminjaman',
            'detailPengembalian.detailPeminjaman.alat',
        ]);

        return view('admin.pengembalian.edit', compact(
            'pengembalian',
            'peminjaman'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $valid = $request->validate([
            'status' => 'required|in:menunggu_verifikasi,selesai',
            'tanggal_pengembalian' => 'required|date',
            'tanggal_verifikasi' => $request->status === 'selesai'
                ? 'required|date|after_or_equal:tanggal_pengembalian'
                : 'nullable|date',
            'items' => $request->status === 'selesai'
                ? 'required|array|min:1'
                : 'nullable|array',
            'items.*.detail_peminjaman_id' => 'required_with:items|exists:detail_peminjaman,id',
            'items.*.kondisi' => 'required_with:items|in:lolos,rusak',
            'items.*.catatan_kondisi' => 'nullable|string',
        ], [
            'tanggal_verifikasi.after_or_equal' => 'Tanggal verifikasi tidak boleh mendahului tanggal pengembalian.',
        ]);

        DB::beginTransaction();

        try {
            $pengembalian->load([
                'peminjaman.detailPeminjaman.alat',
                'detailPengembalian',
            ]);

            // Kalau perlu lock, gunakan refresh
            $pengembalian = Pengembalian::with([
                'peminjaman.detailPeminjaman.alat',
                'detailPengembalian',
            ])
                ->lockForUpdate()
                ->findOrFail($pengembalian->id); // sekarang id-nya pasti integer

            $peminjaman = $pengembalian->peminjaman;

            // validate tanggal pengembalian tidak boleh kurang dari tanggal pinjam
            if ($peminjaman->tanggal_disetujui &&
                Carbon::parse($valid['tanggal_pengembalian'])->lt($peminjaman->tanggal_disetujui)) {
                DB::rollBack();

                return back()->withErrors([
                    'tanggal_pengembalian' => 'Tanggal pengembalian tidak boleh lebih awal dari tanggal peminjaman.',
                ]);
            }

            // vivaldi tanggal pengembalian tidak boleh kurang dari deadline
            if ($peminjaman->deadline &&
                Carbon::parse($valid['tanggal_pengembalian'])->lt($peminjaman->deadline)) {
                DB::rollBack();

                return back()->withErrors([
                    'tanggal_pengembalian' => 'Tanggal pengembalian tidak boleh lebih awal dari deadline peminjaman.',
                ]);
            }

            $pengembalian->update([
                'status' => $valid['status'],
                'tanggal_pengembalian' => $valid['tanggal_pengembalian'],
                'tanggal_verifikasi' => $valid['status'] === 'selesai'
                    ? $valid['tanggal_verifikasi']
                    : null,
            ]);

            $langsungSelesai = $valid['status'] === 'selesai';

            foreach ($peminjaman->detailPeminjaman as $detail) {

                $inputItem = collect($valid['items'] ?? [])
                    ->firstWhere('detail_peminjaman_id', $detail->id);

                $detailPengembalian = DetailPengembalian::where([
                    'pengembalian_id' => $pengembalian->id,
                    'detail_peminjaman_id' => $detail->id,
                ])->first();

                if (! $detailPengembalian) {
                    continue;
                }

                $kondisiBaru = $langsungSelesai
                    ? ($inputItem['kondisi'] ?? $detailPengembalian->kondisi)
                    : 'menunggu_verifikasi';

                $catatanBaru = $langsungSelesai
                    ? ($inputItem['catatan_kondisi'] ?? null)
                    : null;

                if ($detailPengembalian->kondisi === 'lolos') {
                    $detail->alat->decrement('stok', $detail->jumlah);
                }

                $detailPengembalian->update([
                    'kondisi' => $kondisiBaru,
                    'catatan_kondisi' => $catatanBaru,
                ]);

                if ($langsungSelesai && $kondisiBaru === 'lolos') {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }

            DB::commit();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'update',
                'target' => $pengembalian->kode_pengembalian,
                'keterangan' => 'Mengupdate pengembalian dengan status "'.$valid['status'].'"',
                'status' => 'success',
            ]);

            return redirect()
                ->route('admin-pengembalian')
                ->with('success', 'Pengembalian berhasil diupdate.');

        } catch (\Throwable $th) {
            DB::rollBack();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'update',
                'target' => $pengembalian->kode_pengembalian,
                'keterangan' => 'Gagal update pengembalian: '.$th->getMessage(),
                'status' => 'error',
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal update pengembalian: '.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        DB::beginTransaction();

        try {
            $pengembalian->load([
                'peminjaman.detailPeminjaman.alat',
                'detailPengembalian',
            ]);

            // rollback stok kalau kondisi lolos
            foreach ($pengembalian->detailPengembalian as $detail) {
                if ($detail->kondisi === 'lolos') {
                    $detail->detailPeminjaman->alat->decrement('stok', $detail->jumlah_kembali);
                }
            }

            // kembalikan status peminjaman
            $pengembalian->peminjaman->update([
                'status' => $pengembalian->peminjaman->tanggal_kembali < now()
                    ? 'terlambat'
                    : 'jatuh_tempo',
            ]);

            $pengembalian->detailPengembalian()->delete();
            $pengembalian->delete();

            DB::commit();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'delete',
                'target' => $pengembalian->kode_pengembalian,
                'keterangan' => 'Menghapus data pengembalian',
                'status' => 'warning',
            ]);

            return redirect()
                ->route('admin-pengembalian')
                ->with('success', 'Pengembalian berhasil dihapus.');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus pengembalian: '.$th->getMessage());
        }
    }

    private function generateKodePengembalian()
    {
        // ambil 2 digit tahun
        $tahun = now()->format('y');

        // ambil bulan
        $bulan = now()->format('m');

        // prefix kode
        $prefix = "INV-PG-{$tahun}{$bulan}-";

        // cari kode terakhir bulan ini
        $lastpengembalian = Pengembalian::where('kode_pengembalian', 'like', $prefix.'%')
            ->latest('id')
            ->first();

        // default nomor
        $nomor = 1;

        // kalau ada transaksi sebelumnya
        if ($lastpengembalian) {

            // ambil 3 digit terakhir
            $lastNumber = substr($lastpengembalian->kode_pengembalian, -3);

            // increment
            $nomor = intval($lastNumber) + 1;
        }

        // format jadi 3 digit
        $nomor = str_pad($nomor, 3, '0', STR_PAD_LEFT);

        // hasil akhir
        return $prefix.$nomor;
    }
}
