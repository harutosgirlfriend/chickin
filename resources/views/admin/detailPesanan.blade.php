@extends('templateAdmin')
@section('content')
    @php
        $currentStatus = $pesanan->status;
        $allSteps = ['Pending', 'Disetujui', 'Proses Pengantaran', 'Diterima'];
        $currentIndex = array_search($currentStatus, $allSteps);
        $activeColor = 'purple-600';
        $defaultColor = 'gray-300';
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2 bg-gray-100 justify-items-stretch p-10">
        <div class="flex flex-col">
            <div class="card rounded-md bg-white justify-items-center p-10 shadow-lg">

                <h3 class="text-xl font-bold mb-6 text-gray-700">Status Pesanan Saat Ini</h3>



                <div class="max-w-4xl mx-auto w-full">
                    <div id="delivery-tracker" class="flex justify-between items-start relative">


                        @foreach ($allSteps as $index => $step)
                            @php
                                $color = $index <= $currentIndex ? $activeColor : $defaultColor;
                            @endphp

                            <div class="step text-center relative z-30 flex-1 px-2 min-w-0" data-status="{{ $step }}">

                                <div
                                    class="circle w-4 h-4 rounded-full mx-auto mb-2 
                                bg-{{ $color }} border-2 border-{{ $color }} transition-colors duration-500 shadow">
                                </div>

                                <p
                                    class="label text-xs font-medium transition-colors duration-500 whitespace-normal text-{{ $color }}">
                                    {{ $step }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="max-w-sm h-50 mx-auto relative mt-8 overflow-scroll">



                @foreach ($tracking as $track)
                    @php
                        $isActive = $track->status == $currentStatus;

                        $dotColor = $isActive ? $activeColor : $defaultColor;
                        $lineColor = $dotColor;
                    @endphp

                    <div class="flex items-start mb-0 relative">


                        <div class="absolute left-3 top-0 h-full border-l-2 border-{{ $isActive ? 'purple-600' : 'gray-300' }} transform -translate-x-1/2"
                            style="height: calc(100% + 1rem);">
                        </div>
                        <div class="z-10 mr-4 flex-shrink-0 mt-3">
                            <div
                                class="circle w-6 h-6 rounded-full bg-{{ $dotColor }} border-2 border-{{ $dotColor }} shadow-md flex items-center justify-center">
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-5 flex-grow mb-4">
                            <h2 class="text-lg font-bold mb-1 text-gray-800">{{ $track->status }}</h2>
                            <p class="text-sm text-gray-600">
                                Status diperbarui pada {{ $track->updated_at ?? 'Waktu tidak tersedia' }}.
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
            <div class="justify-items-center items-center">

                <button class="p-3 w-96 rounded-md bg-indigo-500 flex justify-center items-center text-white font-semibold">
                    @if ($currentStatus == 'Diterima')
                        <span class="font-semibold">Kembali</span>
                    @elseif($currentStatus == 'Pending')
                        <span class="font-semibold">Setujui Pesanan?</span>
                    @elseif($currentStatus == 'Disetujui')
                        <span class="font-semibold">Pesanan Akan Diantar?</span>
                    @elseif($currentStatus == 'Proses Pengantaran')
                        <span class="font-semibold">Pesanan sudah sampai?</span>
                    @endif



                </button>
            </div>
        </div>




        <div class="card rounded-md bg-white justify-items-center py-5 px-5">
            <h1 class="text-2xl font-bold mb-4 text-gray-800">Rincian Pesanan</h1>
            <div class="w-full mx-auto p-4 space-y-4">

                <div class="bg-white rounded-xl shadow-md p-5 space-y-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Alamat</h2>


                    <div class="flex text-gray-600 border-b border-gray-200 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <div class="alamat">
                            @foreach ($akun as $item)
                                <p class="font-bold text-lg text-green-600">{{ $item->users->nama }}</p>
                                <p class="font-semibold text-green-600">{{ $item->kota }}</p>
                                <p class="font-semibold text-green-600">{{ $item->alamat }}</p>
                            @endforeach
                        </div>


                    </div>
                    {{--                   
                    <div class="flex justify-between text-gray-600 border-b border-gray-200 pb-3">
                        <span class="font-normal">Metode Pembayaran</span>
                        <span class="font-semibold text-green-600">{{ $pesanan['metode_pembayaran']}}</span>
                    </div> --}}

                </div>

                <div class="bg-white rounded-xl shadow-md p-5">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Product</h2>

                    @foreach ($products as $product)
                        <div class="flex items-center justify-between border-b pb-3 w-full">
                            <div class="flex items-center space-x-3 w-full">
                                <img src="{{ asset('images/product/' . $product->product->gambar) }}" alt="Produk"
                                    class="w-16 h-16 rounded-md object-cover">
                                <div>
                                    <p class="font-medium">{{ $product->kode_product }}</p>
                                    <p class="font-medium">{{ $product->product->nama_product }}</p>

                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][kode_product]"
                                        value="{{ $product->kode_product }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][jumlah]"
                                        value="{{ $product->jumlah }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][harga]"
                                        value="{{ $product->product->harga }}">
                                    <input class="font-medium" hidden name="items[{{ $loop->index }}][subtotal]"
                                        value="{{ $product->jumlah * $product->product->harga }}">


                                    <p class="text-sm text-gray-500" id="hargaEl"></p>
                                    <input class="text-sm text-gray-500 intharga" hidden name=""
                                        value="{{ $product->product->harga }}"id="harga">
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">{{ $product->jumlah }}X</p>

                                <p class="text-gray-600 subEl">{{ $product->jumlah * $product->product->harga }}
                                </p>

                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="bg-white rounded-xl shadow-md p-5 space-y-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Pembayaran</h2>

                    <div class="flex justify-between text-gray-600">
                        <span class="font-normal">Total Harga</span>
                        <span class="font-semibold">Rp{{ number_format($pesanan['total_harga']) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 border-b border-gray-200 pb-3">
                        <span class="font-normal">Ongkir</span>
                        <span class="font-semibold">RP{{ number_format($pesanan['ongkir']) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 border-b border-gray-200 pb-3">
                        <span class="font-normal">Metode Pembayaran</span>
                        <span class="font-semibold text-green-600">{{ $pesanan['metode_pembayaran'] }}</span>
                    </div>
                    <div class="flex justify-between pt-2 text-gray-800">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-xl font-extrabold">Rp{{ number_format($pesanan['total_bayar']) }}</span>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection
