<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .kop { text-align:center; border-bottom:2px solid #000; margin-bottom:15px; }
        .kop img { height:50px; vertical-align: middle; margin-right:10px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; text-align:center; }
        th { background-color:#f0f0f0; font-weight:bold; }
        .total-row { font-weight:bold; background-color:#f9f9f9; }
        .ttd { margin-top:40px; width:100%; }
        .ttd td { border:none; text-align:center; }
    </style>
</head>
<body>

<div class="kop">
    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
    <span style="font-size:24px; font-weight:bold; vertical-align: middle;">CHICKin</span>
    <p>Sistem Manajemen Keuangan</p>
    <p>Email: admin@chickin.com | Telp: 08xxxxxxxx</p>
</div>

<p style="text-align:right">
    @if ($filter == 'range' && $tanggal_awal && $tanggal_akhir)
        Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}
    @elseif ($filter == 'bulanan' && $bulan)
        Bulanan: {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}
    @elseif ($filter == 'tahunan' && $tahun)
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
        @php
            $grandTotalHarga = 0;
            $grandTotalHargaAwal = 0;
            $grandTotalPotongan = 0;
            $grandTotalOngkir = 0;
            $grandTotalLaba = 0;
        @endphp

        @foreach ($pendapatan as $penghasilan)
            @php
                $totalHargaAwal = 0;
                foreach ($penghasilan->details as $detail) {
                    $totalHargaAwal += ($detail->product->harga_awal ?? 0) * ($detail->jumlah ?? 1);
                }
                $labaBersih = $penghasilan->total_harga - $totalHargaAwal - ($penghasilan->jumlah_potongan ?? 0);

                $grandTotalHarga += $penghasilan->total_harga;
                $grandTotalHargaAwal += $totalHargaAwal;
                $grandTotalPotongan += $penghasilan->jumlah_potongan ?? 0;
                $grandTotalOngkir += $penghasilan->ongkir;
                $grandTotalLaba += $labaBersih;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
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

        <!-- Row Total -->
        <tr class="total-row">
            <td colspan="3">TOTAL</td>
            <td></td>
            <td>{{ number_format($grandTotalHarga) }}</td>
            <td>{{ number_format($grandTotalHargaAwal) }}</td>
            <td></td>
            <td>{{ number_format($grandTotalPotongan) }}</td>
            <td>{{ number_format($grandTotalOngkir) }}</td>
            <td>{{ number_format($grandTotalLaba) }}</td>
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
