<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .kop { text-align:center; border-bottom:2px solid #000; margin-bottom:15px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; }
        .ttd { margin-top:40px; width:100%; }
    </style>
</head>
<body>

<div class="kop">
    <h2>CHICKin</h2>
    <p>Laporan Stok Produk</p>
</div>

<p style="text-align:right">
    Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
        <tr>
            <td>{{ $p->kode_product }}</td>
            <td>{{ $p->nama_product }}</td>
            <td>{{ $p->kategori }}</td>
            <td>{{ $p->stok == 0 ? '0' : $p->stok }}</td>
            <td>{{ number_format($p->harga) }}</td>
        </tr>
        @endforeach
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
