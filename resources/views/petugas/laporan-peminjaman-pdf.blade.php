<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { color: #363062; margin-bottom: 5px; }
        .header p { color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #363062; color: white; padding: 10px; text-align: left; font-size: 11px; }
        td { border: 1px solid #ddd; padding: 8px; font-size: 10px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Peminjaman</h2>
        <p>Periode: {{ $periode ?? 'Semua' }} | Tanggal Export: {{ $tanggal }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">ID Peminjaman</th>
                <th width="20%">Nama Peminjam</th>
                <th width="15%">Tgl Pinjam</th>
                <th width="15%">Tgl Kembali</th>
                <th width="10%">Jumlah</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamanData as $item)
            <tr>
                <td>{{ $item['no'] }}</td>
                <td>{{ $item['kode_peminjaman'] }}</td>
                <td>{{ $item['nama_peminjam'] }}</td>
                <td>{{ $item['tanggal_pinjam'] }}</td>
                <td>{{ $item['tanggal_kembali'] }}</td>
                <td>{{ $item['jumlah_alat'] }} Alat</td>
                <td>{{ $item['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>