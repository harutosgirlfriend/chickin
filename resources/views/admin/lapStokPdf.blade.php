<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .kop { text-align:center; border-bottom:2px solid #000; margin-bottom:15px; }
        .kop img { height:50px; vertical-align: middle; margin-right:10px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; text-align:center; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .ttd { margin-top:40px; width:100%; }
        .total-row { font-weight:bold; background-color:#f0f0f0; }
    </style>
</head>
<body>

<div class="kop">
    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
    <span style="font-size:24px; font-weight:bold; vertical-align: middle;">CHICKin</span>
    <p>Sistem Manajemen Stok</p>
    <p>Email: admin@chickin.com | Telp: 08xxxxxxxx</p>
</div>

<p style="text-align:right">
    Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>No</th> <!-- Kolom nomor urut -->
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalStok = 0;
            $totalHarga = 0;
        @endphp
        @foreach($products as $p)
            @php
                $totalStok += $p->stok;
                $totalHarga += $p->harga;
            @endphp
        <tr>
            <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
            <td>{{ $p->kode_product }}</td>
            <td>{{ $p->nama_product }}</td>
            <td>{{ $p->kategori }}</td>
            <td>{{ $p->stok == 0 ? '0' : $p->stok }}</td>
            <td>{{ number_format($p->harga) }}</td>
        </tr>
        @endforeach
        <!-- Row Total -->
        <tr class="total-row">
            <td colspan="4">TOTAL</td>
            <td>{{ $totalStok }}</td>
            <td>{{ number_format($totalHarga) }}</td>
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
