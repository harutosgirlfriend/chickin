<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pesanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .kop { text-align: center; margin-bottom: 10px; }
        .ttd { width: 100%; margin-top: 40px; }
        .ttd td { border: none; text-align: center; }
    </style>
</head>
<body>

    <div class="kop">
        <h2>CHICKin</h2>
        <h4>Sistem Manajemen Penjualan</h4>
        <p>Email: admin@chickin.com | Telp: 08xxxxxxxx</p>

        <h3>LAPORAN PESANAN</h3>
        <p>
            @if($filter == 'range' && $tanggal_awal && $tanggal_akhir)
                Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}
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
                <th>Produk</th>
                <th>Total Harga</th>
                <th>Jumlah Potongan</th>
                <th>Ongkir</th>
                <th>Total Bayar</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $row)
            <tr>
                <td>{{ $row->kode_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                <td>
                    @php
                        $produk = $product[$row->kode_transaksi] ?? [];
                        $listProduk = [];
                        foreach($produk as $p){
                            $listProduk[] = $p->nama_product . ' (' . $p->jumlah . ')';
                        }
                    @endphp
                    {{ implode(', ', $listProduk) }}
                </td>
                <td>{{ number_format($row->total_harga) }}</td>
                <td>{{ number_format($row->jumlah_potongan) }}</td>
                <td>{{ number_format($row->ongkir) }}</td>
                <td>{{ number_format($row->total_bayar) }}</td>
                <td>{{ $row->metode_pembayaran }}</td>
                <td>{{ $row->status }}</td>
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
            <td>
                Mengetahui,<br><br><br><br>
                ____________________<br>
                Admin
            </td>
        </tr>
    </table>

</body>
</html>
