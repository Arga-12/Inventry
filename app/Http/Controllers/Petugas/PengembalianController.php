<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use App\Models\DetailPengembalian;
use App\Models\Log;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
// Log
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        // search filter
        $search = $request->input('search');

        $selectedPengembalianId = $request->input('pengembalian_id');

        // 1uery untuk pengembalian dengan status 'menunggu_verifikasi'
        $query = Pengembalian::with(['peminjaman.peminjam', 'detailPengembalian.detailPeminjaman.alat.kategori'])
            ->where('status', 'menunggu_verifikasi')
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_pengembalian', 'like', "%{$search}%")
                    ->orWhereHas('peminjaman.peminjam', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        $menungguList = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_pengembalian' => $item->kode_pengembalian,
                'peminjam' => [
                    'id' => $item->peminjaman->peminjam->id,
                    'nama_lengkap' => $item->peminjaman->peminjam->nama_lengkap ?? 'Unknown',
                    'foto' => $item->peminjaman->peminjam->foto ?? null,
                ],
                'total_item' => $item->detailPengembalian->sum('jumlah_kembali'),
                'tanggal_pengembalian' => $item->tanggal_pengembalian,
                'peminjaman_id' => $item->peminjaman_id,
            ];
        });

        // jika tidak ada pengembalian_id yang dipilih dan ada data, ambil yang pertama
        if (! $selectedPengembalianId && $menungguList->isNotEmpty()) {
            $selectedPengembalianId = $menungguList->first()['id'];
        }

        // ambil detail pengembalian yang dipilih
        $selectedPengembalian = null;
        if ($selectedPengembalianId) {
            $pengembalian = Pengembalian::with([
                'peminjaman.peminjam',
                'peminjaman.detailPeminjaman.alat.kategori',
                'detailPengembalian.detailPeminjaman.alat',
            ])->find($selectedPengembalianId);

            if ($pengembalian) {
                $selectedPengembalian = [
                    'id' => $pengembalian->id,
                    'kode_pengembalian' => $pengembalian->kode_pengembalian,
                    'status' => $pengembalian->status,
                    'tanggal_pengembalian' => $pengembalian->tanggal_pengembalian,
                    'tanggal_verifikasi' => $pengembalian->tanggal_verifikasi,
                    'peminjaman' => [
                        'id' => $pengembalian->peminjaman->id,
                        'kode_peminjaman' => $pengembalian->peminjaman->kode_peminjaman,
                        'durasi' => $pengembalian->peminjaman->durasi,
                        'tanggal_pengajuan' => $pengembalian->peminjaman->tanggal_pengajuan,
                        'tanggal_disetujui' => $pengembalian->peminjaman->tanggal_disetujui,
                        'peminjam' => [
                            'id' => $pengembalian->peminjaman->peminjam->id,
                            'nama_lengkap' => $pengembalian->peminjaman->peminjam->nama_lengkap ?? 'Unknown',
                            'foto' => $pengembalian->peminjaman->peminjam->foto ?? null,
                        ],
                    ],
                    'detail_pengembalian' => $pengembalian->detailPengembalian->map(function ($detail) {
                        $detailPeminjaman = $detail->detailPeminjaman;

                        return [
                            'id' => $detail->id,
                            'jumlah_kembali' => $detail->jumlah_kembali,
                            'kondisi' => $detail->kondisi,
                            'catatan_kondisi' => $detail->catatan_kondisi,
                            'detail_peminjaman' => [
                                'id' => $detailPeminjaman->id,
                                'jumlah' => $detailPeminjaman->jumlah,
                                'alat' => [
                                    'id' => $detailPeminjaman->alat->id,
                                    'nama_alat' => $detailPeminjaman->alat->nama_alat,
                                    'stok' => $detailPeminjaman->alat->stok,
                                    'gambar' => $detailPeminjaman->alat->gambar,
                                    'durasi' => $detailPeminjaman->alat->durasi,
                                    'kategori' => $detailPeminjaman->alat->kategori ? [
                                        'id' => $detailPeminjaman->alat->kategori->id,
                                        'nama_kategori' => $detailPeminjaman->alat->kategori->nama_kategori,
                                    ] : null,
                                ],
                            ],
                        ];
                    }),
                ];
            }
        }

        // stats
        $totalMenunggu = Pengembalian::where('status', 'menunggu_verifikasi')->count();
        $totalAlatDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat']);
        })->count();

        return view('petugas.pengembalian', compact('menungguList', 'selectedPengembalian', 'selectedPengembalianId', 'totalMenunggu', 'totalAlatDipinjam'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        if ($pengembalian->status !== 'menunggu_verifikasi') {
            return back()->with('error', 'Pengembalian ini sudah diproses.');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.detail_pengembalian_id' => 'required|exists:detail_pengembalian,id',
            'items.*.kondisi' => 'required|in:lolos,rusak',
            'items.*.catatan_kondisi' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // update kondisi setiap item
            foreach ($validated['items'] as $item) {
                $detailPengembalian = DetailPengembalian::find($item['detail_pengembalian_id']);
                $detailPengembalian->update([
                    'kondisi' => $item['kondisi'],
                    'catatan_kondisi' => $item['catatan_kondisi'] ?? null,
                ]);

                // kembalikan stok jika kondisi lolos
                if ($item['kondisi'] === 'lolos') {
                    $detailPengembalian->detailPeminjaman->alat->increment('stok', $detailPengembalian->jumlah_kembali);
                }
            }

            // update status pengembalian
            $pengembalian->update([
                'status' => 'selesai',
                'petugas_id' => Auth::id(),
                'tanggal_verifikasi' => now(),
            ]);

            // update status peminjaman menjadi selesai
            $pengembalian->peminjaman->update([
                'status' => 'selesai',
            ]);

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'verify',
                'target' => $pengembalian->kode_pengembalian,
                'keterangan' => 'Petugas memverifikasi pengembalian dengan status selesai.',
                'status' => 'success',
            ]);

            DB::commit();

            return redirect()->route('petugas-pengembalian')
                ->with('success', 'Pengembalian berhasil diverifikasi.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::create([
                'user_id' => Auth::id(),
                'role' => Auth::user()->role,
                'modul' => 'pengembalian',
                'aksi' => 'verify',
                'target' => $pengembalian->kode_pengembalian,
                'keterangan' => 'Gagal memverifikasi pengembalian: '.$e->getMessage(),
                'status' => 'error',
            ]);

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
