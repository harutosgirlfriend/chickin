<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .kop { text-align: center; border-bottom: 2px solid #000; margin-bottom: 15px; }
        .kop img { height: 50px; vertical-align: middle; margin-right: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .ttd { margin-top: 40px; width: 100%; }
        .total-row { font-weight: bold; background-color: #f0f0f0; }
    </style>
</head>
<body>

<div class="kop">
    <img src="{{ public_path('images/logo-laporan.png') }}" alt="Logo">
    <span style="font-size:24px; font-weight:bold; vertical-align: middle;">CHICKin</span>
    <p>Sistem Manajemen Penjualan</p>
    <p>Email: admin@chickin.com | Telp: 08xxxxxxxx</p>
</div>

<p style="text-align:right">
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

<table>
    <thead>
        <tr>
            <th>No</th> <!-- Kolom nomor urut -->
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
        @php
            $grandTotalHarga = 0;
            $grandTotalPotongan = 0;
            $grandTotalOngkir = 0;
            $grandTotalBayar = 0;
        @endphp

        @foreach($pesanan as $row)
            @php
                $produk = $product[$row->kode_transaksi] ?? [];
                $listProduk = [];
                foreach($produk as $p){
                    $listProduk[] = $p->nama_product . ' (' . $p->jumlah . ')';
                }

                $grandTotalHarga += $row->total_harga;
                $grandTotalPotongan += $row->jumlah_potongan;
                $grandTotalOngkir += $row->ongkir;
                $grandTotalBayar += $row->total_bayar;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
                <td>{{ $row->kode_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                <td>{{ implode(', ', $listProduk) }}</td>
                <td>{{ number_format($row->total_harga) }}</td>
                <td>{{ number_format($row->jumlah_potongan) }}</td>
                <td>{{ number_format($row->ongkir) }}</td>
                <td>{{ number_format($row->total_bayar) }}</td>
                <td>{{ $row->metode_pembayaran }}</td>
                <td>{{ $row->status }}</td>
            </tr>
        @endforeach

        <!-- Row Total -->
        <tr class="total-row">
            <td colspan="3">TOTAL</td>
            <td>{{ number_format($grandTotalHarga) }}</td>
            <td>{{ number_format($grandTotalPotongan) }}</td>
            <td>{{ number_format($grandTotalOngkir) }}</td>
            <td>{{ number_format($grandTotalBayar) }}</td>
            <td colspan="3"></td>
        </tr>
    </tbody>
</table>

<table class="ttd">
    <tr>
        <td width="60%"></td>
        <td style="text-align:center">
            Mengetahui,<br><br><br>
            <b>____________________</b><br>
            Admin
        </td>
    </tr>
</table>

</body>
</html>
