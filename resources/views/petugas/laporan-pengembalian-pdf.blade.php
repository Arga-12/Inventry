<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { color: #363062; margin-bottom: 5px; }
        .header p { color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #363062; color: white; padding: 10px; text-align: left; font-size: 11px; }
        td { border: 1px solid #ddd; padding: 8px; font-size: 10px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge-lolos { color: #065f46; font-weight: bold; }
        .badge-rusak { color: #991b1b; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengembalian</h2>
        <p>Periode: {{ $periode ?? 'Semua' }} | Kondisi: {{ $kondisi ?? 'Semua' }} | Tanggal Export: {{ $tanggal }}</p>
        <p>Petugas: {{ $petugas ?? 'Semua Petugas' }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">ID Pengembalian</th>
                <th width="20%">Nama Peminjam</th>
                <th width="15%">Tgl Pengajuan</th>
                <th width="15%">Tgl Verifikasi</th>
                <th width="10%">Jumlah</th>
                <th width="10%">Kondisi</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalianData as $item)
            <tr>
                <td>{{ $item['no'] }}</td>
                <td>{{ $item['kode_pengembalian'] }}</td>
                <td>{{ $item['nama_peminjam'] }}</td>
                <td>{{ $item['tanggal_pengajuan'] }}</td>
                <td>{{ $item['tanggal_verifikasi'] }}</td>
                <td>{{ $item['jumlah_alat'] }} Alat</td>
                <td class="{{ $item['kondisi'] == 'lolos' ? 'badge-lolos' : 'badge-rusak' }}">
                    {{ ucfirst($item['kondisi']) }}
                </td>
                <td>{{ $item['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>