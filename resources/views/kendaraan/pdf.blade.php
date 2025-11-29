<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Kendaraan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
            word-wrap: break-word;
        }

        th {
            background: #f3f3f3;
            font-weight: bold;
        }

        .status-lunas {
            color: green;
            font-weight: bold;
        }

        .status-belum {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="title">LAPORAN DATA KENDARAAN BERMOTOR</div>
    <div class="subtitle">Dicetak pada: {{ date('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 100px;">Nopol</th>
                <th style="width: 130px;">Nama WP</th>
                <th style="width: 100px;">Merek</th>
                <th style="width: 100px;">Tipe</th>
                <th style="width: 60px;">Tahun</th>
                <th style="width: 80px;">Warna</th>
                <th style="width: 90px;">Status Pajak</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($kendaraan as $k)
                @php
                    $status = $k->pembayaran ? 'LUNAS' : 'BELUM LUNAS';
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nopol }}</td>
                    <td>{{ $k->wajibPajak->nama ?? '-' }}</td>
                    <td>{{ $k->merek }}</td>
                    <td>{{ $k->tipe }}</td>
                    <td>{{ $k->tahun_pembuatan }}</td>
                    <td>{{ $k->warna }}</td>

                    <td class="{{ $status == 'LUNAS' ? 'status-lunas' : 'status-belum' }}">
                        {{ $status }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:15px;">
                        Tidak ada data kendaraan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan dicetak oleh sistem pada {{ date('d-m-Y H:i:s') }}
    </div>

</body>
</html>
