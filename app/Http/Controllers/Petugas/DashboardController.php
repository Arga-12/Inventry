<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $petugasId = Auth::id();

        // card meunggu disetujui
        $menungguPersetujuan = Peminjaman::with('peminjam', 'detailPeminjaman')
            ->where('status', 'menunggu')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->peminjam->nama_lengkap ?? 'Unknown',
                    'foto' => $item->peminjam->foto ?? null,
                    'total_item' => $item->detailPeminjaman->sum('jumlah'),
                    'id' => $item->id,
                ];
            });

        $totalMenungguPersetujuan = Peminjaman::where('status', 'menunggu')->count();

        // card dipinjam
        $menungguKonfirmasi = Pengembalian::with('peminjaman.peminjam', 'detailPengembalian')
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->peminjaman->peminjam->nama_lengkap ?? 'Unknown',
                    'foto' => $item->peminjaman->peminjam->foto ?? null,
                    'total_item' => $item->detailPengembalian->sum('jumlah_kembali'),
                    'id' => $item->id,
                ];
            });

        $totalMenungguKonfirmasi = Pengembalian::where('status', 'menunggu_verifikasi')->count();

        // aktivitas petugas dngan card style git commit
        $totalPengajuanDiterima = Peminjaman::where('petugas_id', $petugasId)
            ->whereIn('status', ['selesai', 'ditolak'])
            ->count();

        $totalPengembalianDilakukan = Pengembalian::where('petugas_id', $petugasId)
            ->where('status', 'selesai')
            ->count();

        $chartData = $this->getChartData($petugasId);

        return view('petugas.dashboard', compact(
            'menungguPersetujuan',
            'totalMenungguPersetujuan',
            'menungguKonfirmasi',
            'totalMenungguKonfirmasi',
            'totalPengajuanDiterima',
            'totalPengembalianDilakukan',
            'chartData'
        ));
    }

    private function getChartData($petugasId)
    {
        $year = date('Y');
        $months = [];

        // Nama bulan
        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create($year, $m, 1)->format('M');
        }

        // data per minggu per bulan
        $weeklyData = [];
        $totalData = [];
        $weeklyColors = [];
        $totalColors = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

            // total per bulan
            $totalApproved = Peminjaman::where('petugas_id', $petugasId)
                ->whereBetween('tanggal_disetujui', [$startOfMonth, $endOfMonth])
                ->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat', 'selesai'])
                ->count();

            $totalVerified = Pengembalian::where('petugas_id', $petugasId)
                ->where('status', 'selesai')
                ->whereBetween('tanggal_verifikasi', [$startOfMonth, $endOfMonth])
                ->count();

            $total = $totalApproved + $totalVerified;
            $totalData[] = $total;
            $totalColors[] = $this->getColorIntensity($total);

            // data per minggu dalam bulan ini
            $weeksInMonth = [];
            $weekColors = [];
            $currentWeekStart = $startOfMonth->copy();
            $weekNumber = 1;

            while ($currentWeekStart <= $endOfMonth) {
                $weekEnd = $currentWeekStart->copy()->endOfWeek();
                if ($weekEnd > $endOfMonth) {
                    $weekEnd = $endOfMonth;
                }

                $approvedLoans = Peminjaman::where('petugas_id', $petugasId)
                    ->whereBetween('tanggal_disetujui', [$currentWeekStart, $weekEnd])
                    ->whereIn('status', ['dipinjam', 'jatuh_tempo', 'terlambat', 'selesai'])
                    ->count();

                $verifiedReturns = Pengembalian::where('petugas_id', $petugasId)
                    ->where('status', 'selesai')
                    ->whereBetween('tanggal_verifikasi', [$currentWeekStart, $weekEnd])
                    ->count();

                $count = $approvedLoans + $verifiedReturns;
                $weeksInMonth[$weekNumber] = $count;
                $weekColors[$weekNumber] = $this->getColorIntensity($count);

                $currentWeekStart = $weekEnd->copy()->addDay();
                $weekNumber++;
            }

            $weeklyData[$month] = $weeksInMonth;
            $weeklyColors[$month] = $weekColors;
        }

        return [
            'months' => $months,
            'weeklyData' => $weeklyData,
            'weeklyColors' => $weeklyColors,
            'totalData' => $totalData,
            'totalColors' => $totalColors,
            'year' => $year,
            'maxWeeks' => 4,
        ];
    }

    private function getColorIntensity($count)
    {
        if ($count == 0) {
            return '#F3F4F6';
        }

        $maxCount = 20;
        $intensity = min(1, $count / $maxCount);

        $baseColor = [77, 76, 125];
        $lightColor = [230, 230, 245];

        $r = round($lightColor[0] - ($lightColor[0] - $baseColor[0]) * $intensity);
        $g = round($lightColor[1] - ($lightColor[1] - $baseColor[1]) * $intensity);
        $b = round($lightColor[2] - ($lightColor[2] - $baseColor[2]) * $intensity);

        return sprintf('rgb(%d, %d, %d)', $r, $g, $b);
    }
}
