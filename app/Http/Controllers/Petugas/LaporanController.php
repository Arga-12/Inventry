<?php

namespace App\Http\Controllers\Petugas;

use App\Exports\LaporanPeminjamanExport;
use App\Exports\LaporanPengembalianExport;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Peminjaman;
// Log
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;
// export file
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $petugasId = Auth::id();

        // peminjaman
        $peminjamanData = $this->getPeminjamanData($request, $petugasId, true);
        $peminjamanList = $peminjamanData['list'];
        $peminjamanCollection = $peminjamanData['collection'];

        // pengembalian
        $pengembalianData = $this->getPengembalianData($request, $petugasId, true);
        $pengembalianList = $pengembalianData['list'];
        $pengembalianCollection = $pengembalianData['collection'];

        // statistik card
        $peminjamanHariIni = Peminjaman::whereDate('tanggal_pengajuan', Carbon::today())
            ->whereIn('status', ['selesai', 'ditolak'])
            ->where('petugas_id', $petugasId)->count();

        $pengembalianHariIni = Pengembalian::whereDate('tanggal_verifikasi', Carbon::today())
            ->where('status', 'selesai')
            ->where('petugas_id', $petugasId)->count();

        $totalPeminjamanAll = Peminjaman::whereIn('status', ['selesai', 'ditolak'])
            ->where('petugas_id', $petugasId)->count();

        $totalPengembalianAll = Pengembalian::where('status', 'selesai')
            ->where('petugas_id', $petugasId)->count();

        $totalAktivitasAll = $totalPeminjamanAll + $totalPengembalianAll;

        $diagramAktivitas = [
            [
                'nama' => 'Peminjaman',
                'warna' => '#4D4C7D',
                'count' => $totalPeminjamanAll,
                'persen' => $totalAktivitasAll > 0 ? round(($totalPeminjamanAll / $totalAktivitasAll) * 100) : 0,
            ],
            [
                'nama' => 'Pengembalian',
                'warna' => '#F99417',
                'count' => $totalPengembalianAll,
                'persen' => $totalAktivitasAll > 0 ? round(($totalPengembalianAll / $totalAktivitasAll) * 100) : 0,
            ],
        ];

        return view('petugas.laporan', compact(
            'peminjamanCollection', 'peminjamanList',
            'pengembalianCollection', 'pengembalianList',
            'diagramAktivitas', 'peminjamanHariIni', 'pengembalianHariIni',
            'totalPeminjamanAll', 'totalPengembalianAll'
        ) + $this->getFilterValues($request));
    }

    // priv buat fiulter filter
    private function getFilterValues(Request $request)
    {
        return [
            'periode' => $request->periode ?? 'semua',
            'search' => $request->search,
            'statusPeminjaman' => $request->status_peminjaman ?? 'semua',
            'periodePengembalian' => $request->periode_pengembalian ?? 'semua',
            'searchPengembalian' => $request->search_pengembalian,
            'kondisiPengembalian' => $request->kondisi_pengembalian ?? 'semua',
        ];
    }

    private function getPeminjamanQuery(Request $request, $petugasId)
    {
        $query = Peminjaman::with(['peminjam', 'detailPeminjaman', 'pengembalian'])
            ->whereIn('status', ['selesai', 'ditolak'])
            ->where('petugas_id', $petugasId);

        // filter periode
        switch ($request->periode) {
            case 'hari_ini':
                $query->whereDate('tanggal_pengajuan', Carbon::today());
                break;
            case 'minggu_ini':
                $query->whereBetween('tanggal_pengajuan', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'bulan_ini':
                $query->whereMonth('tanggal_pengajuan', Carbon::now()->month);
                break;
            case 'tahun_ini':
                $query->whereYear('tanggal_pengajuan', Carbon::now()->year);
                break;
        }

        // filter status
        if ($request->status_peminjaman && $request->status_peminjaman != 'semua') {
            $query->where('status', $request->status_peminjaman);
        }

        // search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_peminjaman', 'like', "%{$request->search}%")
                    ->orWhereHas('peminjam', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$request->search}%"));
            });
        }

        return $query->orderBy('tanggal_pengajuan', 'desc');
    }

    private function getPeminjamanData(Request $request, $petugasId, $withPagination = false)
    {
        $query = $this->getPeminjamanQuery($request, $petugasId);

        if ($withPagination) {
            $list = $query->paginate(10);
            $collection = $list->map(fn ($item, $i) => $this->mapPeminjaman($item, $i));

            return ['list' => $list, 'collection' => $collection];
        }

        return $query->get()->map(fn ($item, $i) => $this->mapPeminjaman($item, $i));
    }

    private function mapPeminjaman($item, $index)
    {
        $tanggalKembali = null;
        if ($item->status == 'selesai' && $item->pengembalian && $item->pengembalian->status == 'selesai') {
            $tanggalKembali = $item->pengembalian->tanggal_verifikasi;
        }

        return [
            'no' => $index + 1,
            'id' => $item->id,
            'kode_peminjaman' => $item->kode_peminjaman,
            'nama_peminjam' => $item->peminjam->nama_lengkap ?? 'Unknown',
            'tanggal_pinjam' => $item->tanggal_pengajuan,
            'waktu_pinjam' => $item->tanggal_pengajuan,
            'tanggal_kembali' => $tanggalKembali,
            'waktu_kembali' => $tanggalKembali,
            'jumlah_alat' => $item->detailPeminjaman->sum('jumlah'),
            'status' => $item->status,
            'status_badge' => $item->getStatusBadgeAttribute(),
            'status_label' => $item->getStatusLabelAttribute(),
        ];
    }

    private function getPengembalianQuery(Request $request, $petugasId)
    {
        $query = Pengembalian::with(['peminjaman.peminjam', 'detailPengembalian'])
            ->where('status', 'selesai')
            ->where('petugas_id', $petugasId);

        // filter periode
        switch ($request->periode_pengembalian) {
            case 'hari_ini':
                $query->whereDate('tanggal_verifikasi', Carbon::today());
                break;
            case 'minggu_ini':
                $query->whereBetween('tanggal_verifikasi', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'bulan_ini':
                $query->whereMonth('tanggal_verifikasi', Carbon::now()->month);
                break;
            case 'tahun_ini':
                $query->whereYear('tanggal_verifikasi', Carbon::now()->year);
                break;
        }

        // filter kondisi
        if ($request->kondisi_pengembalian && $request->kondisi_pengembalian != 'semua') {
            $query->whereHas('detailPengembalian', fn ($q) => $q->where('kondisi', $request->kondisi_pengembalian));
        }

        // search
        if ($request->search_pengembalian) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_pengembalian', 'like', "%{$request->search_pengembalian}%")
                    ->orWhereHas('peminjaman.peminjam', fn ($q2) => $q2->where('nama_lengkap', 'like', "%{$request->search_pengembalian}%"));
            });
        }

        return $query->latest();
    }

    private function getPengembalianData(Request $request, $petugasId, $withPagination = false)
    {
        $query = $this->getPengembalianQuery($request, $petugasId);

        if ($withPagination) {
            $list = $query->paginate(10);
            $collection = $list->map(fn ($item) => $this->mapPengembalian($item));

            return ['list' => $list, 'collection' => $collection];
        }

        return $query->get()->map(fn ($item, $i) => $this->mapPengembalian($item, $i));
    }

    private function mapPengembalian($item, $index = null)
    {
        return [
            'no' => $index !== null ? $index + 1 : null,
            'kode_pengembalian' => $item->kode_pengembalian,
            'nama_peminjam' => $item->peminjaman->peminjam->nama_lengkap ?? 'Unknown',
            'tanggal_pengajuan' => $item->tanggal_pengembalian,
            'tanggal_verifikasi' => $item->tanggal_verifikasi,
            'jumlah_alat' => $item->detailPengembalian->sum('jumlah_kembali'),
            'kondisi' => $item->detailPengembalian->first()?->kondisi ?? 'lolos',
            'status_badge' => 'bg-green-100 text-green-700',
            'status_label' => 'Selesai',
            'status' => 'Selesai',
        ];
    }

    // METOD METOD EXPORT

    public function exportPeminjamanExcel(Request $request)
    {
        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'laporan',
            'aksi' => 'export_excel',
            'target' => 'laporan-peminjaman',
            'keterangan' => 'Petugas mengekspor laporan peminjaman ke Excel. Filter: periode='.($request->periode ?? 'semua').', status='.($request->status_peminjaman ?? 'semua'),
            'status' => 'success',
        ]);

        return Excel::download(
            new LaporanPeminjamanExport($request),
            'laporan-peminjaman-'.now()->format('d-m-Y').'.xlsx'
        );
    }

    public function exportPeminjamanPDF(Request $request)
    {
        $petugasId = Auth::id();
        $peminjamanData = $this->getPeminjamanData($request, $petugasId);

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'laporan',
            'aksi' => 'export_pdf',
            'target' => 'laporan-peminjaman',
            'keterangan' => 'Petugas mengekspor laporan peminjaman ke PDF. Filter: periode='.($request->periode ?? 'semua').', status='.($request->status_peminjaman ?? 'semua'),
            'status' => 'success',
        ]);

        $pdf = Pdf::loadView('petugas.laporan-peminjaman-pdf', [
            'peminjamanData' => $peminjamanData,
            'periode' => $request->periode ?? 'semua',
            'status' => $request->status_peminjaman ?? 'semua',
            'tanggal' => now()->format('d-m-Y'),
            'petugas' => Auth::user()->nama_lengkap,
        ]);

        return $pdf->stream('laporan-peminjaman-'.now()->format('d-m-Y').'.pdf');
    }

    public function exportPengembalianExcel(Request $request)
    {
        $petugasId = Auth::id();
        $pengembalianList = $this->getPengembalianData($request, $petugasId);

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'laporan',
            'aksi' => 'export_excel',
            'target' => 'laporan-pengembalian',
            'keterangan' => 'Petugas mengekspor laporan pengembalian ke Excel. Filter: periode='.($request->periode_pengembalian ?? 'semua').', kondisi='.($request->kondisi_pengembalian ?? 'semua'),
            'status' => 'success',
        ]);

        return Excel::download(
            new LaporanPengembalianExport($pengembalianList, $request->periode_pengembalian ?? 'semua', $request->kondisi_pengembalian ?? 'semua'),
            'laporan-pengembalian-'.now()->format('d-m-Y').'.xlsx'
        );
    }

    public function exportPengembalianPDF(Request $request)
    {
        $petugasId = Auth::id();
        $pengembalianData = $this->getPengembalianData($request, $petugasId);

        Log::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'modul' => 'laporan',
            'aksi' => 'export_pdf',
            'target' => 'laporan-pengembalian',
            'keterangan' => 'Petugas mengekspor laporan pengembalian ke PDF. Filter: periode='.($request->periode_pengembalian ?? 'semua').', kondisi='.($request->kondisi_pengembalian ?? 'semua'),
            'status' => 'success',
        ]);

        $pdf = Pdf::loadView('petugas.laporan-pengembalian-pdf', [
            'pengembalianData' => $pengembalianData,
            'periode' => $request->periode_pengembalian ?? 'semua',
            'kondisi' => $request->kondisi_pengembalian ?? 'semua',
            'tanggal' => now()->format('d-m-Y'),
            'petugas' => Auth::user()->nama_lengkap,
        ]);

        return $pdf->stream('laporan-pengembalian-'.now()->format('d-m-Y').'.pdf');
    }
}
