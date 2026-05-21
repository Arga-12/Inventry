<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use App\Models\Log;
use App\Models\Peminjaman;
use Carbon\Carbon;
// Log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // search filter
        $search = $request->input('search');

        // 1uery untuk peminjaman dengan status 'menunggu'
        $menungguList = Peminjaman::with(['peminjam', 'detailPeminjaman.alat.kategori'])
            ->where('status', 'menunggu')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('kode_peminjaman', 'like', "%{$search}%")
                        ->orWhereHas('peminjam', function ($q2) use ($search) {
                            $q2->where('nama_lengkap', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kode_peminjaman' => $item->kode_peminjaman,
                    'peminjam' => [
                        'id' => $item->peminjam->id,
                        'nama_lengkap' => $item->peminjam->nama_lengkap ?? 'Unknown',
                        'foto' => $item->peminjam->foto ?? null,
                    ],
                    'total_item' => $item->detailPeminjaman->sum('jumlah'),
                    'tanggal_pengajuan' => $item->tanggal_pengajuan,
                    'durasi' => $item->durasi,
                ];
            });

        $selectedPeminjamanId = $request->input('peminjaman_id');

        if (! $selectedPeminjamanId && $menungguList->isNotEmpty()) {
            $selectedPeminjamanId = $menungguList->first()['id'];
        }

        // ambil detail peminjaman yang dipilih
        $selectedPeminjaman = null;
        if ($selectedPeminjamanId) {
            $peminjaman = Peminjaman::with(['peminjam', 'detailPeminjaman.alat.kategori', 'petugas'])
                ->find($selectedPeminjamanId);

            if ($peminjaman) {
                $durasi = $peminjaman->durasi ?? $peminjaman->detailPeminjaman->first()?->alat?->durasi ?? 0;

                $selectedPeminjaman = [
                    'id' => $peminjaman->id,
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                    'status' => $peminjaman->status,
                    'durasi' => $durasi,
                    'deadline' => $peminjaman->deadline,
                    'tanggal_pengajuan' => $peminjaman->tanggal_pengajuan,
                    'tanggal_disetujui' => $peminjaman->tanggal_disetujui,
                    'peminjam' => [
                        'id' => $peminjaman->peminjam->id,
                        'nama_lengkap' => $peminjaman->peminjam->nama_lengkap ?? 'Unknown',
                        'foto' => $peminjaman->peminjam->foto ?? null,
                    ],
                    'petugas' => $peminjaman->petugas ? [
                        'id' => $peminjaman->petugas->id,
                        'nama_lengkap' => $peminjaman->petugas->nama_lengkap ?? 'Unknown',
                    ] : null,
                    'detail_peminjaman' => $peminjaman->detailPeminjaman->map(function ($detail) {
                        return [
                            'id' => $detail->id,
                            'jumlah' => $detail->jumlah,
                            'alat' => [
                                'id' => $detail->alat->id,
                                'nama_alat' => $detail->alat->nama_alat,
                                'stok' => $detail->alat->stok,
                                'gambar' => $detail->alat->gambar,
                                'kategori' => $detail->alat->kategori ? [
                                    'id' => $detail->alat->kategori->id,
                                    'nama_kategori' => $detail->alat->kategori->nama_kategori,
                                ] : null,
                            ],
                        ];
                    }),
                ];
            }
        }

        // stats
        $totalMenunggu = Peminjaman::where('status', 'menunggu')->count();
        $totalDipinjamHariIni = Peminjaman::whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat'])
            ->whereDate('tanggal_disetujui', Carbon::today())
            ->count();

        $totalAlatDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat']);
        })->sum('jumlah');

        return view('petugas.peminjaman', compact('menungguList', 'selectedPeminjaman', 'selectedPeminjamanId', 'totalMenunggu', 'totalDipinjamHariIni', 'totalAlatDipinjam'));
    }

    public function update(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        // ambil durasi dari peminjaman, kalau null ambil dari alat pertama
        $durasi = $peminjaman->detailPeminjaman->first()?->alat?->durasi ?? 0;

        if ($durasi <= 0) {
            return back()->with('error', 'Durasi peminjaman tidak valid.');
        }

        // count deadline dari SEKARANG + durasi
        $now = now();
        $deadline = $now->copy()->addMinutes($durasi);

        // update status peminjaman
        $peminjaman->update([
            'status' => 'dipinjam',
            'petugas_id' => auth()->id(),
            'tanggal_disetujui' => now(),
            'durasi' => $durasi,
            'deadline' => $deadline,
        ]);

        // kurangi stok alat
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->alat->decrement('stok', $detail->jumlah);
        }

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'peminjaman',
            'aksi' => 'approve',
            'target' => $peminjaman->kode_peminjaman,
            'keterangan' => 'Petugas menyetujui peminjaman.',
            'status' => 'success',
        ]);

        return redirect()->route('petugas-peminjaman')
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'petugas_id' => auth()->id(),
            'tanggal_disetujui' => now(),
        ]);

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'peminjaman',
            'aksi' => 'reject',
            'target' => $peminjaman->kode_peminjaman,
            'keterangan' => 'Petugas menolak peminjaman.',
            'status' => 'warning', // atau 'success' tergantung kebutuhan
        ]);

        return redirect()->route('petugas-peminjaman')
            ->with('success', 'Peminjaman berhasil ditolak.');
    }
}
