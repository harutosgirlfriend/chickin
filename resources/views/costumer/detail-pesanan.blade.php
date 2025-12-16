@extends('template')

@section('title', 'Detail Produk')

@section('content')
<div class="bg-white p-4 sm:p-6 shadow-lg rounded-xl max-w-lg mx-auto my-8 font-sans">

        <div class="pt-3 mt-3  py-10">
  
            <div class="flex justify-between text-lg">
                <span class="font-semibold text-gray-900">No Pesanan</span>
                <span class="font-extrabold text-gray-900">{{ $kode_transaksi }}</span>
            </div>
        </div>
    <div class="space-y-4 pb-4 border-b border-gray-200">
        @foreach ($pesanan as $item)
             <div class="flex items-center space-x-4">

            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-gray-100 bg-gray-100">
                <img class="w-full h-full object-cover" src="{{ asset('images/product/' . $item->product->gambar) }}" alt="Arm Chair">
            </div>
            <div class="flex-grow">
                <p class="text-gray-900 font-medium text-base">{{ $item->product->nama_product }}</p>
                <p class="text-gray-500 text-sm">{{ $item->product->kategori }}</p>
                <p class="text-gray-700 text-sm mt-1 flex justify-between">
                    <span class="font-semibold"> Rp{{ number_format($item->product->harga) }}</span>
                    <span class="font-semibold">Rp{{ number_format($item->subtotal) }}   |  {{ $item->jumlah }}x</span>   
                </p>
            </div>

        </div>
        @endforeach
       
    </div>
    

    <div class="space-y-2 text-sm text-gray-700 pb-4 border-b border-gray-200 my-5">

        <div class="flex justify-between">
            <span class="text-gray-500">Tanggal Pesan</span>
            <span class="font-medium text-gray-900">  {{ date('m-d-Y', strtotime($item->transaksi->tanggal))  }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Kode Promo</span>
            <span class="font-medium text-gray-900">FR1254HGGWE</span>
        </div>
    
        <div class="flex justify-between">
            <span class="text-gray-500">Status</span>
            <span class="font-medium text-green-500">{{ $item->transaksi->status }}</span>
        </div>
    </div>


    <div class="space-y-2 my-5">
        <div class="flex justify-between text-base">
            <span class="text-gray-500">Ongkir</span>
            <span class="font-medium text-gray-900">Rp{{ number_format($item->transaksi->ongkir) }}</span>
        </div>


        <div class="flex justify-between text-base">
            <span class="text-gray-500">Total Harga</span>
            <span class="font-medium text-gray-900">Rp{{ number_format($item->transaksi->total_harga) }}</span>
        </div>

  
        <div class="flex justify-between text-base">
            <span class="text-gray-500">Metode Pembayaran</span>
            <span class="font-medium text-green-600">{{ $item->transaksi->metode_pembayaran}}</span>
        </div>

        <div class="pt-3 mt-3 border-t border-gray-200">
  
            <div class="flex justify-between text-lg">
                <span class="font-semibold text-gray-900">Total Bayar</span>
                <span class="font-extrabold text-gray-900">Rp{{ number_format($item->transaksi->total_harga + $item->transaksi->ongkir) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
