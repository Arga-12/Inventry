<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Log;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // filter tahun untuk chart
        $tahun = $request->input('tahun', Carbon::now()->year);

        $dataPeminjaman = [];
        $dataPengembalian = [];
        $bulanLabels = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $bulanLabels[] = Carbon::create()->month($bulan)->translatedFormat('F');

            $dataPeminjaman[] = Peminjaman::where('status', 'selesai')
                ->whereYear('tanggal_pengajuan', $tahun)
                ->whereMonth('tanggal_pengajuan', $bulan)
                ->count();

            $dataPengembalian[] = Pengembalian::where('status', 'selesai')
                ->whereYear('tanggal_pengembalian', $tahun)
                ->whereMonth('tanggal_pengembalian', $bulan)
                ->count();
        }

        // chart
        $chart = [
            'dataPeminjaman' => $dataPeminjaman,
            'dataPengembalian' => $dataPengembalian,
            'bulanLabels' => $bulanLabels,
            'tahun' => $tahun,
            'totalData' => array_sum($dataPeminjaman) + array_sum($dataPengembalian),
        ];

        // data stoks
        $totalStok = Alat::sum('stok');
        $kategoriStok = Kategori::withSum('alat', 'stok')->get();

        $persentaseKategori = [];
        foreach ($kategoriStok as $kategori) {
            $persentaseKategori[] = [
                'nama' => $kategori->nama_kategori,
                'warna' => $kategori->warna ?? '#F99417',
                'stok' => $kategori->alat_sum_stok ?? 0,
                'persentase' => $totalStok > 0 ? round(($kategori->alat_sum_stok / $totalStok) * 100, 2) : 0,
            ];
        }

        $stok = [
            'total' => $totalStok,
            'kategori' => $kategoriStok,
            'persentase' => $persentaseKategori,
            'menipis' => Alat::with('kategori')
                ->where('stok', '<=', 5)
                ->where('stok', '>', 0)
                ->orderBy('stok', 'asc')
                ->limit(5)
                ->get(),
        ];

        // data user onliune
        $usersOnline = Pengguna::whereNotNull('last_activity')
            ->where('last_activity', '>=', now()->subMinutes(5))
            ->get();

        $userStats = [
            'online' => [
                'peminjam' => $usersOnline->where('role', 'peminjam')->count(),
                'petugas' => $usersOnline->where('role', 'petugas')->count(),
                'admin' => $usersOnline->where('role', 'admin')->count(),
                'total' => $usersOnline->count(),
            ],
            'list' => $usersOnline->take(9),
        ];

        // latest logs
        $latestLogs = Log::with('user')
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('chart', 'stok', 'userStats', 'latestLogs'));
    }
}
