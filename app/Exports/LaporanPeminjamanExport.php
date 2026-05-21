<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPeminjamanExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    protected $periode;

    protected $status;

    protected $search;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->periode = $request->periode ?? 'semua';
        $this->status = $request->status_peminjaman ?? 'semua';
        $this->search = $request->search;
    }

    public function collection()
    {
        $query = Peminjaman::with(['peminjam', 'detailPeminjaman', 'pengembalian'])
            ->whereIn('status', ['selesai', 'ditolak']);

        // Filter periode
        switch ($this->periode) {
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

        // Filter status
        if ($this->status && $this->status != 'semua') {
            $query->where('status', $this->status);
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_peminjaman', 'like', "%{$this->search}%")
                    ->orWhereHas('peminjam', function ($q2) {
                        $q2->where('nama_lengkap', 'like', "%{$this->search}%");
                    });
            });
        }

        return $query->orderBy('tanggal_pengajuan', 'desc')->get();
    }

    public function headings(): array
    {
        $periodeText = match ($this->periode) {
            'hari_ini' => 'Hari Ini',
            'minggu_ini' => 'Minggu Ini',
            'bulan_ini' => 'Bulan Ini',
            'tahun_ini' => 'Tahun Ini',
            default => 'Semua Waktu',
        };

        $statusText = $this->status == 'semua' ? 'Semua Status' : ($this->status == 'selesai' ? 'Selesai' : 'Ditolak');

        return [
            ['LAPORAN PEMINJAMAN ALAT'],
            ['Periode: '.$periodeText.' | Status: '.$statusText],
            ['Tanggal Cetak: '.now()->format('d-m-Y H:i:s')],
            [],
            ['No', 'ID Peminjaman', 'Nama Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali (Seluruh Item)', 'Jumlah Alat', 'Status'],
        ];
    }

    public function map($item): array
    {
        static $no = 1;

        $tanggalKembali = '-';
        if ($item->status == 'selesai' && $item->pengembalian && $item->pengembalian->status == 'selesai') {
            $tanggalKembali = $item->pengembalian->tanggal_verifikasi->format('d-m-Y H:i');
        }

        return [
            $no++,
            $item->kode_peminjaman,
            $item->peminjam->nama_lengkap ?? '-',
            $item->tanggal_pengajuan->format('d-m-Y H:i'),
            $tanggalKembali,
            $item->detailPeminjaman->sum('jumlah').' Alat',
            $item->getStatusLabelAttribute(),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerRow = 5; // Baris header utama (No, ID Peminjaman, dll)
        $lastColumn = 'G'; // Karena ada 7 kolom (A-G)

        // Merge title cells (A1 sampai G1, G2, G3 sesuai jumlah kolom)
        $sheet->mergeCells('A1:'.$lastColumn.'1');
        $sheet->mergeCells('A2:'.$lastColumn.'2');
        $sheet->mergeCells('A3:'.$lastColumn.'3');

        // Style title (baris 1-3)
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        // Style header (baris 5)
        $sheet->getStyle($headerRow.':'.$lastColumn.$headerRow)->getFont()->setBold(true);
        $sheet->getStyle($headerRow.':'.$lastColumn.$headerRow)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF363062');
        $sheet->getStyle($headerRow.':'.$lastColumn.$headerRow)->getFont()->getColor()->setARGB('FFFFFFFF');

        // Auto size columns sudah di handle oleh ShouldAutoSize
        return [];
    }
}
