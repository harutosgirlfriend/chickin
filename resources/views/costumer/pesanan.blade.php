@extends('template')

@section('title', 'Pesanan')

@section('content')
    <div class="flex flex-col p-6 items-center w-full">

        @if ($transaksi)
            @foreach ($transaksi as $item)
                @php
                    $kode_transaksi = $item->kode_transaksi;
                    $daftar_produk = $product[$kode_transaksi];
                    $status_transaksi = $item->status ?? 'Status Default';

                    $status_class = match ($status_transaksi) {
                        'Proses Pengantaran' => 'bg-green-500 text-white',
                        'Pending' => 'bg-blue-500 text-white',
                        'Ditolak' => 'bg-red-500 text-white',
                        'Dibatalkan' => 'bg-red-500 text-white',
                        'Diterima' => 'bg-green-500 text-white',
                        default => 'bg-gray-500 text-white',
                    };
                @endphp

                <div class="w-full sm:w-2/3 md:w-1/2 lg:w-1/2 mx-auto my-4">

                    <div
                        class="bg-amber-50 p-5 rounded-xl shadow-lg border border-amber-100 relative
                            hover:shadow-xl transition duration-300">


                        <div class="absolute top-3 right-3">

                            <span
                                class="px-3 py-1 text-xs font-semibold uppercase tracking-wide rounded-full {{ $status_class }}">
                                {{ $status_transaksi }}
                            </span>

                        </div>


                        <div class="flex gap-4 items-start">


                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border bg-white">
                                @foreach ($daftar_produk as $detail_product)
                                    <img class="w-full h-full object-cover"
                                        src="{{ asset('images/product/' . $detail_product['gambar']) }}" alt="Gambar Produk">
                                @endforeach
                            </div>


                            <div class="flex flex-col gap-1">
                                @if (count($daftar_produk) > 1)
                                    <p class="text-sm font-medium text-gray-600">
                                        {{ count($daftar_produk) }} Produk
                                    </p>
                                @endif

                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $item->kode_transaksi }}
                                </p>

                                <p class="text-xl font-bold text-yellow-600">
                                    {{ $item->total_harga }}
                                </p>
                            </div>
                        </div>


                        <div class="flex flex-col mt-4 gap-2">

                            <div class="flex items-center text-sm text-gray-500 space-x-4 border-b border-gray-300 pb-3">

                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ date('m-d-Y', strtotime($item['tanggal'])) }}
                                </span>
                            </div>

                            <a href="{{ route('detail.pesanan', $item->kode_transaksi) }}"
                                class="text-sm font-medium text-center text-gray-600
                                   hover:text-[#a01800] transition pt-2">
                                @if ($item->metode_pembayaran == 'airpay shopee')
                                    ShopeePay
                                @else
                                    {{ $item->metode_pembayaran }}
                                @endif

                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        @else
        @endif

    </div>
@endsection
