<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPengembalianExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $pengembalianList;

    protected $periode;

    protected $kondisi;

    public function __construct($pengembalianList, $periode, $kondisi)
    {
        $this->pengembalianList = $pengembalianList;
        $this->periode = $periode;
        $this->kondisi = $kondisi;
    }

    public function collection()
    {
        return $this->pengembalianList;
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

        $kondisiText = $this->kondisi == 'semua' ? 'Semua Kondisi' : ucfirst($this->kondisi);

        return [
            ['LAPORAN PENGEMBALIAN ALAT'],
            ['Periode: '.$periodeText.' | Kondisi: '.$kondisiText],
            ['Tanggal Cetak: '.now()->format('d-m-Y H:i:s')],
            [],
            ['No', 'Kode Pengembalian', 'Nama Peminjam', 'Tanggal Pengajuan', 'Tanggal Verifikasi', 'Jumlah Alat', 'Kondisi', 'Status'],
        ];
    }

    public function map($item): array
    {
        static $no = 1;

        return [
            $no++,
            $item->kode_pengembalian,
            $item->peminjaman->peminjam->nama_lengkap ?? '-',
            $item->tanggal_pengembalian ? Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y H:i') : '-',
            $item->tanggal_verifikasi ? Carbon::parse($item->tanggal_verifikasi)->format('d-m-Y H:i') : '-',
            $item->detailPengembalian->sum('jumlah_kembali').' Alat',
            ucfirst($item->detailPengembalian->first()?->kondisi ?? 'lolos'),
            'Selesai',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerRow = 5;
        $lastColumn = 'H'; // 8 kolom (A-H)

        // Merge title cells
        $sheet->mergeCells('A1:'.$lastColumn.'1');
        $sheet->mergeCells('A2:'.$lastColumn.'2');
        $sheet->mergeCells('A3:'.$lastColumn.'3');

        // Style title
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);

        // Style header
        $sheet->getStyle($headerRow.':'.$lastColumn.$headerRow)->getFont()->setBold(true);
        $sheet->getStyle($headerRow.':'.$lastColumn.$headerRow)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF363062');
        $sheet->getStyle($headerRow.':'.$lastColumn.$headerRow)->getFont()->getColor()->setARGB('FFFFFFFF');

        return [];
    }
}
