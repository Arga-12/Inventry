<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display peminjam dashboard.
     */
    public function index(Request $request)
    {
        Peminjaman::syncAllActivePeminjaman();

        $user = Auth::user();

        // stat total pinjam
        $allPeminjaman = Peminjaman::where('peminjam_id', $user->id)->get();
        $totalPeminjaman = $allPeminjaman->count();

        // stat per kategori untuk chart
        $kategoriStats = $this->getKategoriStats($user->id);

        // peminjaman aktif saat ini
        $activePeminjaman = Peminjaman::with(['detailPeminjaman.alat.kategori', 'peminjam', 'petugas'])
            ->where('peminjam_id', $user->id)
            ->whereIn('status', ['dipinjam', 'jatuh_tempo'])
            ->latest()
            ->get();

        // deadline
        foreach ($activePeminjaman as $peminjaman) {
            if ($peminjaman->deadline) {
                $peminjaman->deadline_format = $peminjaman->deadline->format('d/m H:i');
                $peminjaman->deadline_timestamp = $peminjaman->deadline->timestamp;
            } else {
                $peminjaman->deadline_format = '-';
                $peminjaman->deadline_timestamp = null;
            }

            $alatNames = $peminjaman->detailPeminjaman->map(function ($detail) {
                return $detail->alat->nama_alat;
            })->implode(', ');
            $peminjaman->daftar_alat = $alatNames;
        }

        // rekom alat random
        $recommendedAlat = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $searchQuery = $request->input('search');
        $searchResults = null;

        if ($searchQuery) {
            $searchResults = Alat::with('kategori')
                ->where('nama_alat', 'like', "%{$searchQuery}%")
                ->orWhere('kode_alat', 'like', "%{$searchQuery}%")
                ->where('stok', '>', 0)
                ->limit(10)
                ->get();
        }

        return view('peminjam.dashboard', compact(
            'user',
            'totalPeminjaman',
            'kategoriStats',
            'activePeminjaman',
            'recommendedAlat',
            'searchQuery',
            'searchResults'
        ));
    }

    /**
     * Get statistik peminjaman per kategori untuk chart.
     */
    private function getKategoriStats($userId)
    {
        $kategoris = Kategori::with(['alat' => function ($query) use ($userId) {
            $query->whereHas('detailPeminjaman.peminjaman', function ($q) use ($userId) {
                $q->where('peminjam_id', $userId);
            });
        }])->get();

        $stats = [];

        foreach ($kategoris as $kategori) {
            $total = 0;
            foreach ($kategori->alat as $alat) {
                $total += $alat->detailPeminjaman->sum('jumlah');
            }

            if ($total > 0) {
                $stats[] = [
                    'nama' => $kategori->nama_kategori,
                    'total' => $total,
                    'color' => $kategori->warna,
                    'warna_kategori' => $kategori->warna,
                ];
            }
        }

        $grandTotal = collect($stats)->sum('total');
        foreach ($stats as &$stat) {
            $stat['percentage'] = $grandTotal > 0 ? round(($stat['total'] / $grandTotal) * 100) : 0;
        }

        return $stats;
    }

    // handle search alat buat di laman peminjam-alat
    public function searchAlat(Request $request)
    {
        $query = $request->input('q');

        if (! $query || strlen($query) < 2) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $results = Alat::with('kategori')
            ->where(function ($q) use ($query) {
                $q->where('nama_alat', 'like', "%{$query}%")
                    ->orWhere('kode_alat', 'like', "%{$query}%");
            })
            ->where('stok', '>', 0)
            ->limit(10)
            ->get()
            ->map(function ($alat) {
                return [
                    'id' => $alat->id,
                    'kode_alat' => $alat->kode_alat,
                    'nama_alat' => $alat->nama_alat,
                    'stok' => $alat->stok,
                    'durasi' => $alat->durasi,
                    'gambar' => $alat->gambar,
                    'kategori' => $alat->kategori ? [
                        'nama_kategori' => $alat->kategori->nama_kategori,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}
