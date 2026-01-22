<table border="1" style="border-collapse:collapse; width:100%; text-align:center;">
    <thead>

        <tr>
            <th colspan="9" style="font-size:16pt; font-weight:bold; text-align:center;">
                <img src="{{ public_path('images/logo-laporan.png') }}"
                    style="height:50px; vertical-align:middle; margin-right:10px;">
                <span>CHICKin</span>
            </th>
        </tr>
        <tr>
            <th colspan="9" style="font-size:12pt; text-align:center;">Laporan Penjualan</th>
        </tr>

        <tr>
            <th colspan="9" style="font-size:12pt; text-align:center;">
                @if (request()->filter == 'range' && request()->filled('tanggal_awal') && request()->filled('tanggal_akhir'))
                    Periode: {{ \Carbon\Carbon::parse(request()->tanggal_awal)->format('d F Y') }}
                    s/d {{ \Carbon\Carbon::parse(request()->tanggal_akhir)->format('d F Y') }}
                @elseif(request()->filter == 'bulanan' && request()->filled('bulan'))
                    Bulanan: {{ \Carbon\Carbon::parse(request()->bulan)->translatedFormat('F Y') }}
                @elseif(request()->filter == 'tahunan' && request()->filled('tahun'))
                    Tahunan: {{ request()->tahun }}
                @else
                    Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                @endif
            </th>
        </tr>

        <tr>
            <th colspan="9"></th>
        </tr> <!-- Spasi sebelum tabel -->

        <!-- Header Tabel -->
        <tr style="background-color:#f0f0f0; font-weight:bold;">
            <th style="border:1px solid black;">Kode Transaksi</th>
            <th style="border:1px solid black;">Tanggal</th>
            <th style="border:1px solid black;">Produk</th>
            <th style="border:1px solid black;">Total Harga</th>
            <th style="border:1px solid black;">Jumlah Potongan</th>
            <th style="border:1px solid black;">Ongkir</th>
            <th style="border:1px solid black;">Total Bayar</th>
            <th style="border:1px solid black;">Metode Pembayaran</th>
            <th style="border:1px solid black;">Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalHarga = 0;
            $totalPotongan = 0;
            $totalOngkir = 0;
            $totalBayar = 0;
        @endphp

        @foreach ($data as $row)
            @php
                $totalHarga += $row->total_harga;
                $totalPotongan += $row->jumlah_potongan;
                $totalOngkir += $row->ongkir;
                $totalBayar += $row->total_bayar;
            @endphp
            <tr>
                <td style="border:1px solid black;">{{ $row->kode_transaksi }}</td>
                <td style="border:1px solid black;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                <td style="border:1px solid black;">{{ $row->produk }}</td>
                <td style="border:1px solid black;">{{ number_format($row->total_harga) }}</td>
                <td style="border:1px solid black;">{{ number_format($row->jumlah_potongan) }}</td>
                <td style="border:1px solid black;">{{ number_format($row->ongkir) }}</td>
                <td style="border:1px solid black;">{{ number_format($row->total_bayar) }}</td>
                <td style="border:1px solid black;">{{ $row->metode_pembayaran }}</td>
                <td style="border:1px solid black;">{{ $row->status }}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold; background-color:#f9f9f9;">
            <td colspan="3" style="border:1px solid black;">TOTAL</td>
            <td style="border:1px solid black;">{{ number_format($totalHarga) }}</td>
            <td style="border:1px solid black;">{{ number_format($totalPotongan) }}</td>
            <td style="border:1px solid black;">{{ number_format($totalOngkir) }}</td>
            <td style="border:1px solid black;">{{ number_format($totalBayar) }}</td>
            <td colspan="2" style="border:1px solid black;"></td>
        </tr>
    </tbody>
</table>

<!-- Tanda Tangan -->
<table border="0" style="width:100%; margin-top:40px;">
    <tr>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="width:70%;"></td>
        <td style="text-align:center;">
            Mengetahui,<br><br><br><br>
            ____________________<br>
            Admin
        </td>
    </tr>
</table>
