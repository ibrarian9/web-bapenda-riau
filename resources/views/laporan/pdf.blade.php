<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pajak</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

    <h2 style="text-align:center;">LAPORAN PEMBAYARAN PAJAK</h2>

    <p>
        <strong>Periode:</strong>
        {{ $dari ?? '-' }} s/d {{ $sampai ?? '-' }} <br>
        <strong>Jenis Pajak:</strong> {{ $jenis }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>No Kendaraan</th>
                <th>Nama Wajib Pajak</th>
                <th>Jenis Pajak</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($pembayaran as $pb)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($pb->tanggal_bayar)->format('d-m-Y') }}</td>
                    <td>{{ $pb->kendaraan->nopol }}</td>
                    <td>{{ $pb->kendaraan->wajibPajak->nama }}</td>
                    <td>{{ $pb->jenis_pajak }}</td>
                    <td class="text-right">
                        {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5" class="bold text-center">TOTAL</td>
                <td class="bold text-right">
                    {{ number_format($total, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
