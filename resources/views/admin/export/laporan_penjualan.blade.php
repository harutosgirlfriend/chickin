<table border="1">
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
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->kode_transaksi }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->produk }}</td>
                <td>{{ $row->total_harga }}</td>
                <td>{{ $row->jumlah_potongan }}</td>
                <td>{{ $row->ongkir }}</td>
                <td>{{ $row->total_bayar }}</td>
                <td>{{ $row->metode_pembayaran }}</td>
                <td>{{ $row->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
