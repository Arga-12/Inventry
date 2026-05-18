<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Kategori;
use App\Models\Alat;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Models\DetailPengembalian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // search
        $search = $request->input('search');

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

        // im waitinhg
        $menunggu = Pengembalian::with([
            'peminjaman.peminjam',
            'detailPengembalian.detailPeminjaman.alat.kategori',
        ])
            ->where('status', 'menunggu_verifikasi')

            ->when($search, function ($query, $search) {
                $query->where('kode_pengembalian', 'like', "%{$search}%")
                    ->orWhereHas('peminjaman.peminjam', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    });
            })

            ->latest()
            ->get();

        // im done
        $selesai = Pengembalian::with([
            'peminjaman.peminjam',
            'detailPengembalian.detailPeminjaman.alat.kategori',
        ])->where('status', 'selesai')

            ->when($search, function ($query, $search) {
                $query->where('kode_pengembalian', 'like', "%{$search}%")
                    ->orWhereHas('peminjaman.peminjam', function ($q) use ($search) {
                        $q->where('nama_lengkap', 'like', "%{$search}%");
                    });
            })

            ->latest()
            ->get();

        return view('admin.pengembalian.index', compact('menunggu', 'selesai', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Peminjaman $peminjaman)
    {
        $peminjaman->load(['peminjam', 'detailPeminjaman.alat.kategori', 'pengembalian',]);

        // hanya peminjaman aktif
        if (!in_array($peminjaman->status, [
            'dipinjam',
            'jatuh_tempo',
            'terlambat'
        ])) {

            return back()->with(
                'error',
                'Peminjaman ini tidak dapat dikembalikan.'
            );
        }

        // cegah double pengembalian
        if ($peminjaman->pengembalian) {
            return back()->with(
                'error',
                'Pengembalian sudah dibuat.'
            );
        }

        // another return..
        return view('admin.pengembalian.create', compact('peminjaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'status' => 'required|in:menunggu_verifikasi,selesai',
        ]);

        DB::beginTransaction();

        try {

            // lock peminjaman biar aman dari race condition
            $peminjaman = Peminjaman::lockForUpdate()
                ->with([
                    'pengembalian',
                    'detailPeminjaman.alat',
                ])
                ->findOrFail($validated['peminjaman_id']);

            // hanya boleh dari status jatuh tempo / terlambat
            if (!in_array($peminjaman->status, [
                'jatuh_tempo',
                'terlambat'
            ])) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'peminjaman_id' =>
                            'Peminjaman belum dapat dikembalikan.'
                    ]);
            }

            // cegah duplicate pengembalian
            if ($peminjaman->pengembalian()->exists()) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'peminjaman_id' =>
                            'Pengembalian untuk peminjaman ini sudah dibuat.'
                    ]);
            }

            // wajib punya detail peminjaman
            if ($peminjaman->detailPeminjaman->isEmpty()) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'peminjaman_id' =>
                            'Detail peminjaman tidak ditemukan.'
                    ]);
            }

            // kalau selesai, stok langunsg go back
            $langsungSelesai = $validated['status'] === 'selesai';

            // create pengembalian
            $pengembalian = Pengembalian::create([
                'kode_pengembalian' => $this->generateKodePengembalian(),
                'peminjaman_id' => $peminjaman->id,
                'petugas_id' => Auth::id(),
                'status' => $validated['status'],
                'tanggal_pengembalian' => now(),
                'tanggal_verifikasi' => $langsungSelesai
                    ? now()
                    : null,
            ]);

            // copy semua detail peminjaman
            foreach ($peminjaman->detailPeminjaman as $detail) {

                DetailPengembalian::create([
                    'pengembalian_id' => $pengembalian->id,
                    'detail_peminjaman_id' => $detail->id,
                    'jumlah_kembali' => $detail->jumlah,
                    'kondisi' => $langsungSelesai
                        ? 'lolos'
                        : 'menunggu_verifikasi',
                    'catatan_kondisi' => null,
                ]);
                
                // balikin stok alat nya
                if ($langsungSelesai) {
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

            DB::commit();

            return redirect()
                ->route('admin-pengembalian')
                ->with(
                    'success',
                    'Pengembalian berhasil dibuat dan menunggu verifikasi.'
                );

        } catch (\Throwable $th) {

            DB::rollBack();

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

    private function generateKodePengembalian()
    {
        // ambil 2 digit tahun
        $tahun = now()->format('y');

        // ambil bulan
        $bulan = now()->format('m');

        // prefix kode
        $prefix = "INV-PG-{$tahun}{$bulan}-";

        // cari kode terakhir bulan ini
        $lastpengembalian = Pengembalian::where('kode_pengembalian', 'like', $prefix . '%')
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
        return $prefix . $nomor;
    }
}
