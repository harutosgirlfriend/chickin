@extends('template')

@section('title', 'Detail Produk')

@section('content')
  <div class="flex flex-col p-5 items-center w-full">
    @if($transaksi)
    @foreach ($transaksi as $item)
        @php
            $kode_transaksi = $item->kode_transaksi;
            $daftar_produk = $product[$kode_transaksi];
            $status_transaksi = $item->status ?? 'Status Default'; 

            $status_class = match ($status_transaksi) {
                'Proses Pengantaran' => 'bg-green-500 text-white',
                'Pending' => 'bg-blue-500 text-white',
                'Ditolak' => 'bg-red-500 text-white',
                default => 'bg-gray-500 text-white',
            };
        @endphp
        <div class="w-full sm:w-2/3 md:w-1/2 lg:w-1/2 mx-auto my-4">

            <div class="bg-amber-50 p-4 rounded-lg shadow-md border border-amber-100 relative"> 

                <div class="absolute top-0 right-0 mt-2 mr-2">
                    <span class="px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full {{ $status_class }}">
                        {{ $status_transaksi }}
                    </span>
                </div>
             

                <div class="flex space-x-3 items-start">

                    <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                        @foreach ($daftar_produk as $detail_product)
                            <img class="w-full h-full object-cover"
                                src="{{ asset('images/product/' . $detail_product['gambar']) }}" alt="Gambar Produk">
                        @endforeach
                    </div>

                    <div class="flex flex-col">
                        @if (count($daftar_produk) > 1)
                            <p class="text-lg font-semibold text-gray-800">
                                {{ count($daftar_produk) }} Produk
                            </p>
                        @endif
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $item->kode_transaksi }}
                        </p>
                    
                        <p class="text-2xl font-bold text-yellow-600 mt-0">
                            {{ $item->total_harga }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col mt-2">

                    <div class="flex items-center text-sm text-gray-500 mb-2 space-x-4 border-b border-gray-300 pb-2">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                           {{ date('m-d-Y', strtotime($item['tanggal']))  }}
                        </span>
                        {{-- <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            05:15 PM
                        </span> --}}
                    </div>

                    <a href="{{ route('detail.pesanan', $item->kode_transaksi) }}" class="text-sm text-gray-600 font-medium text-center pt-2">
                        {{ $item->metode_pembayaran }}
                </a>
                </div>

            </div>
        </div>
    @endforeach
    @else
    
    @endif  
    
{{--    
    <div style="border: 1px solid #007bff; padding: 15px; margin-bottom: 20px;">
        </div> --}}
</div>
@endsection
