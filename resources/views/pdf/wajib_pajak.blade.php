<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { text-align: center; margin-bottom: 10px; font-weight: bold; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid black; padding: 6px; font-size: 12px; }
        th { background: #e5e7eb; font-weight: bold; }
        .logo { width: 70px; }
    </style>
</head>
<body>

    <div style="text-align:center;">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <p style="margin:5px 0; font-weight:bold;">PEMERINTAH PROVINSI RIAU</p>
        <p style="margin:0;">BADAN PENDAPATAN DAERAH (BAPENDA)</p>
    </div>

    <p class="title">LAPORAN DATA WAJIB PAJAK</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Nopol</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $i => $wp)
                @php
                    $kendaraan = $wp->kendaraans->first();
                    $status = $kendaraan && $kendaraan->pembayaran ? 'LUNAS' : 'BELUM LUNAS';
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $wp->nik }}</td>
                    <td>{{ $wp->nama }}</td>
                    <td>{{ $wp->nomor_hp }}</td>
                    <td>{{ $wp->alamat }}</td>
                    <td>{{ $kendaraan?->nopol ?? '-' }}</td>
                    <td>{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
