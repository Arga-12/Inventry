<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\DetailPengembalian;
use App\Models\Log;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
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

        // menunggu
        $menungguQuery = Peminjaman::with(['detailPeminjaman.alat.kategori', 'pengembalian'])
            ->where('peminjam_id', Auth::id())
            ->where('status', 'menunggu');

        if ($request->filled('search_menunggu')) {
            $search = $request->search_menunggu;
            $menungguQuery->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                    ->orWhereHas('detailPeminjaman.alat', function ($q2) use ($search) {
                        $q2->where('nama_alat', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('durasi_menunggu')) {
            $menungguQuery->where('durasi', $request->durasi_menunggu);
        }

        $menunggu = $menungguQuery->latest()->get();

        // dipinjam
        $dipinjamQuery = Peminjaman::with(['detailPeminjaman.alat.kategori', 'pengembalian'])
            ->where('peminjam_id', Auth::id())
            ->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat']);

        if ($request->filled('search_dipinjam')) {
            $search = $request->search_dipinjam;
            $dipinjamQuery->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                    ->orWhereHas('detailPeminjaman.alat', function ($q2) use ($search) {
                        $q2->where('nama_alat', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('durasi_dipinjam')) {
            $dipinjamQuery->where('durasi', $request->durasi_dipinjam);
        }

        if ($request->filled('status_dipinjam')) {
            $dipinjamQuery->where('status', $request->status_dipinjam);
        }

        $dipinjam = $dipinjamQuery->latest()->get();

        // riwayat
        $riwayatQuery = Peminjaman::with(['detailPeminjaman.alat.kategori', 'pengembalian'])
            ->where('peminjam_id', Auth::id())
            ->whereIn('status', ['selesai', 'ditolak']);

        if ($request->filled('search_riwayat')) {
            $search = $request->search_riwayat;
            $riwayatQuery->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                    ->orWhereHas('detailPeminjaman.alat', function ($q2) use ($search) {
                        $q2->where('nama_alat', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('durasi_riwayat')) {
            $riwayatQuery->where('durasi', $request->durasi_riwayat);
        }

        if ($request->filled('status_riwayat')) {
            $riwayatQuery->where('status', $request->status_riwayat);
        }

        $riwayat = $riwayatQuery->latest()->paginate(4);

        // prosess card
        foreach ($menunggu as $item) {
            $cardStatus = $item->card_status;
            $item->real_status_label = $cardStatus['label'];
            $item->real_status_badge = $cardStatus['badge'];
            $item->can_return = in_array($cardStatus['label'], ['Jatuh Tempo', 'Terlambat']);
        }

        foreach ($dipinjam as $item) {
            $cardStatus = $item->card_status;
            $item->real_status_label = $cardStatus['label'];
            $item->real_status_badge = $cardStatus['badge'];
            $item->can_return = in_array($cardStatus['label'], ['Jatuh Tempo', 'Terlambat']);
        }

        foreach ($riwayat as $item) {
            $cardStatus = $item->card_status;
            $item->real_status_label = $cardStatus['label'];
            $item->real_status_badge = $cardStatus['badge'];
            $item->can_return = in_array($cardStatus['label'], ['Jatuh Tempo', 'Terlambat']);
        }

        // durasi list
        $durasiList = Peminjaman::where('peminjam_id', Auth::id())
            ->whereNotNull('durasi')
            ->select('durasi')
            ->distinct()
            ->orderBy('durasi')
            ->pluck('durasi');

        $formattedDurasiList = [];
        foreach ($durasiList as $durasi) {
            $hours = floor($durasi / 60);
            $mins = $durasi % 60;
            $label = $hours > 0 ? $hours.' Jam '.($mins > 0 ? $mins.' Menit' : '') : $mins.' Menit';
            $formattedDurasiList[] = [
                'value' => $durasi,
                'label' => trim($label),
            ];
        }

        // status untuk filter
        $statusList = [
            ['value' => 'menunggu', 'label' => 'Menunggu'],
            ['value' => 'dipinjam', 'label' => 'Dipinjam'],
            ['value' => 'jatuh_tempo', 'label' => 'Jatuh Tempo'],
            ['value' => 'terlambat', 'label' => 'Terlambat'],
        ];

        $statusRiwayatList = [
            ['value' => 'selesai', 'label' => 'Selesai'],
            ['value' => 'ditolak', 'label' => 'Ditolak'],
        ];

        return view('peminjam.peminjaman', compact(
            'menunggu', 'dipinjam', 'riwayat',
            'formattedDurasiList', 'durasiList',
            'statusList', 'statusRiwayatList'
        ));
    }

    /**
     * Format peminjaman data dengan status real-time
     */
    private function formatPeminjamanData($peminjaman)
    {
        foreach ($peminjaman as $item) {
            $item->real_status = $item->status;
            $item->real_status_label = $item->status_label;
            $item->real_status_badge = $item->status_badge;

            // Hitung status real-time untuk yang sedang dipinjam
            if (! is_null($item->deadline) && in_array($item->status, ['dipinjam', 'jatuh_tempo'])) {
                $deadline = Carbon::parse($item->deadline);
                $lateTime = $deadline->copy()->addMinutes(10);
                $now = Carbon::now();

                if ($now->greaterThanOrEqualTo($lateTime)) {
                    $item->real_status = 'terlambat';
                    $item->real_status_label = 'Terlambat';
                    $item->real_status_badge = 'bg-red-100 text-red-700 border-red-200';
                } elseif ($now->greaterThanOrEqualTo($deadline)) {
                    $item->real_status = 'jatuh_tempo';
                    $item->real_status_label = 'Jatuh Tempo';
                    $item->real_status_badge = 'bg-orange-100 text-orange-700 border-orange-200';
                }
            }

            // format tanggal
            $item->formatted_tanggal_pengajuan = Carbon::parse($item->tanggal_pengajuan)->format('d/m/Y H:i');
            $item->formatted_tanggal_disetujui = $item->tanggal_disetujui ? Carbon::parse($item->tanggal_disetujui)->format('d/m/Y H:i') : null;

            // format deadline untuk countdown
            if ($item->deadline) {
                $item->deadline_timestamp = Carbon::parse($item->deadline)->toIso8601String();
                $item->late_time_timestamp = Carbon::parse($item->deadline)->addMinutes(10)->toIso8601String();
            }

            // format durasi alat
            foreach ($item->detailPeminjaman as $detail) {
                $detail->formatted_durasi = $this->formatDurasi($detail->alat->durasi);
                $detail->gambar_url = $detail->alat->gambar
                    ? asset('storage/'.$detail->alat->gambar)
                    : asset('images/id1.jpg');
            }
        }

        return $peminjaman;
    }

    /**
     * Format durasi menit ke text
     */
    private function formatDurasi($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        $result = '';
        if ($hours > 0) {
            $result .= $hours.' Jam ';
        }
        if ($mins > 0) {
            $result .= $mins.' Menit';
        }

        return trim($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Ajukan pengembalian oleh peminjam
     */
    public function ajukanPengembalian(Request $request, $kode_peminjaman)
    {
        try {
            // cari peminjaman
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode_peminjaman)
                ->where('peminjam_id', Auth::id())
                ->firstOrFail();

            // validate status peminjaman
            if (! in_array($peminjaman->status, ['dipinjam', 'jatuh_tempo', 'terlambat'])) {
                return redirect()->back()->with('error', 'Peminjaman ini tidak dapat dikembalikan karena statusnya '.$peminjaman->status_label);
            }

            // cek apakah sudah ada pengajuan pengembalian
            if ($peminjaman->pengembalian) {
                return redirect()->back()->with('error', 'Pengembalian sudah diajukan sebelumnya');
            }

            DB::beginTransaction();

            $kodePengembalian = $this->generateKodePengembalian();

            $pengembalian = Pengembalian::create([
                'kode_pengembalian' => $kodePengembalian,
                'peminjaman_id' => $peminjaman->id,
                'petugas_id' => null,
                'status' => 'menunggu_verifikasi',
                'tanggal_pengembalian' => Carbon::now(),
                'tanggal_verifikasi' => null,
            ]);

            // buat detail peminjaman
            foreach ($peminjaman->detailPeminjaman as $detail) {
                DetailPengembalian::create([
                    'pengembalian_id' => $pengembalian->id,
                    'detail_peminjaman_id' => $detail->id,
                    'jumlah_kembali' => $detail->jumlah,
                    'kondisi' => 'menunggu_verifikasi',
                    'catatan_kondisi' => null,
                ]);
            }

            $peminjaman->update([
                'status' => 'selesai',
            ]);

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'create',
                'target' => $kodePengembalian,
                'keterangan' => 'Peminjam mengajukan pengembalian untuk peminjaman '.$peminjaman->kode_peminjaman,
                'status' => 'success',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pengembalian berhasil diajukan! Menunggu verifikasi petugas.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'create',
                'target' => $kode_peminjaman ?? null,
                'keterangan' => 'Gagal mengajukan pengembalian: '.$e->getMessage(),
                'status' => 'error',
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
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
