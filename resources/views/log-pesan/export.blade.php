<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #e5e5e5; }
    </style>
</head>
<body>

<h3 style="text-align:center;">LAPORAN LOG PESAN WHATSAPP</h3>
<p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Wajib Pajak</th>
            <th>No HP</th>
            <th>Pesan</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($logs as $log)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $log->nama_wajib_pajak }}</td>
            <td>{{ $log->nomor_hp }}</td>
            <td>{{ $log->pesan }}</td>
            <td>{{ $log->status }}</td>
            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
