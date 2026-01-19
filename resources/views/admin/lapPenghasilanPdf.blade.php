<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penghasilan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            border: none;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="kop">
        <h2>CHICKin</h2>
        <h4>Sistem Manajemen Penghasilan</h4>
        <p>Email: admin@chickin.com | Telp: 08xxxxxxxx</p>
        <p>
            @if ($filter == 'range' && $tanggal_awal && $tanggal_akhir)
                Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->format('d F Y') }} s/d
                {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}
            @elseif($filter == 'bulanan' && $bulan)
                Bulanan: {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}
            @elseif($filter == 'tahunan' && $tahun)
                Tahunan: {{ $tahun }}
            @else
                Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Jumlah Produk</th>
                <th>Total Harga</th>
                <th>Total Harga Awal</th>
                <th>Metode Pembayaran</th>
                <th>Jumlah Potongan</th>
                <th>Ongkir</th>
                <th>Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendapatan as $penghasilan)
                @php
                    $totalHargaAwal = 0;
                    foreach ($penghasilan->details as $detail) {
                        $totalHargaAwal += ($detail->product->harga_awal ?? 0) * ($detail->jumlah ?? 1);
                    }
                    $labaBersih = $penghasilan->total_harga - $totalHargaAwal - ($penghasilan->jumlah_potongan ?? 0);
                @endphp
                <tr>
                    <td>{{ $penghasilan->kode_transaksi }}</td>
                    <td>{{ \Carbon\Carbon::parse($penghasilan->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $penghasilan->jumlah_produk }} Produk</td>
                    <td>{{ number_format($penghasilan->total_harga) }}</td>
                    <td>{{ number_format($totalHargaAwal) }}</td>
                    <td>{{ $penghasilan->metode_pembayaran }}</td>
                    <td>{{ number_format($penghasilan->jumlah_potongan ?? 0) }}</td>
                    <td>{{ number_format($penghasilan->ongkir) }}</td>
                    <td>{{ number_format($labaBersih) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="ttd">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                Mengetahui,<br><br><br><br>
                ____________________<br>
                Admin
            </td>
        </tr>
    </table>

</body>

</html>
