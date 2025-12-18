@extends('template')

@section('title', 'Detail Produk')

@section('content')
    <div
        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 bg-gray-100 justify-items-stretch p-10 rounded-md">


        <div class="card rounded-md bg-white justify-items-center p-10">
            <div class="relative">
                <div x-data="{ currentImage: '{{ asset('images/product/' . $product->gambar) }}' }">

                    {{-- GAMBAR UTAMA --}}
                    <img :src="currentImage" class="w-full max-w-md h-96 object-cover rounded-lg shadow-md mx-auto">

                    {{-- THUMBNAILS --}}
                    <div class="flex gap-2 mt-3">
                        @foreach ($product->productgambar as $gmbr)
                            <img src="{{ asset('images/product/' . $gmbr->gambar) }}"
                                class="w-16 h-16 object-cover rounded cursor-pointer hover:border-red-400"
                                @click="currentImage = '{{ asset('images/product/' . $gmbr->gambar) }}'">
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="card bg-white justify-items-left rounded-md p-10 ">


            <h1 class="font-bold text-2xl text-red-800" id="nama_product">{{ $product->nama_product }}</h1>
            <h1 class="font-bold" id="nama_product">Rp {{ number_format($product->harga) }}</h1>
            <h1 class="font-bold hidden" id="kode_product">{{ $product->kode_product }}</h1>


            <div class="flex items-center">
                <button class="kurangi shadow-xl shadow-[#e4c6ba]/90 px-2 py-0.5 mx-0 rounded-md bg-gray-100"><i
                        class="fa-solid fa-minus"></i>
                </button>
                <span class="jumlah px-2 py-2  mx-2" id="jumlah" data-jumlah="0">0</span>
                <button class="tambah shadow-xl shadow-[#e4c6ba]/90 bg-gray-100 px-2 py-0.5  mx-0 rounded-md"
                    data-stok ="{{ $product->stok }}"><i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="flex items-center justify-items-center mt-5 gap-2">
                <form action="{{ route('simpan.keranjang') }}">
                    <input class="text-sm text-gray-500" hidden name="nama_product" value ="{{ $product->nama_product }}">
                    <input class="text-sm text-gray-500" hidden name="kode_product" value ="{{ $product->kode_product }}">
                    <input class="text-sm text-gray-500 jumlahPD" hidden name="jumlah" value ="">

                    <button type="submit"
                        class="flex items-center p-2 my-2 bg-[#b25353] text-white font-semibold rounded-md text-center shadow-xl shadow-[#e4c6ba]/50 justify-items-center
        @if ($product->stok <= 0) bg-gray-300 text-gray-500 border-gray-500 cursor-not-allowed @endif"
                        id="keranjang" data-gambar="{{ $product->gambar }}" data-kode={{ $product->kode_product }}
                        data-harga={{ $product->harga }} data-nama="{{ $product->nama_product }}" {{-- BARIS KUNCI: Tambahkan atribut 'disabled' jika stok <= 0 --}}
                        @if ($product->stok <= 0) disabled @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 2.25h1.386c.51 0 .96.343 1.09.835l.383 1.437m0 0 1.35 5.072a2.25 2.25 0 0 0 2.183 1.706h8.647a2.25 2.25 0 0 0 2.183-1.706l1.35-5.072H5.109Zm3.141 12a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm9.75 0a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" />
                        </svg>

                    </button>

                </form>
                <form action="{{ route('checkout') }}">
                    <input class="text-sm text-gray-500" hidden name="kode_product" value ="{{ $product->kode_product }}">
                    <input class="text-sm text-gray-500" id="jumlahPD" name="jumlah" value ="" hidden>
                    <button id="belibtn" @if ($product->stok <= 0) disabled @endif
                        class="p-3 bg-red-800 text-white font-semibold rounded-md text-center shadow-xl shadow-[#e4c6ba]/50 flex justify-items-center @if ($product->stok <= 0) bg-gray-300 text-gray-500 border-gray-500 cursor-not-allowed @endif">
                        <span class="font-semibold P-3 text">BELI SEKARANG</span>
                    </button>
                </form>
            </div>



            <div class="deskripsi p-1 w-2/3 text-justify">
                <p>{{ $product->deskripsi }}</p>
            </div>
            @php
                $avgRating = round($product->feedback->avg('rating'), 1);
                $totalRating = $product->feedback->count();
            @endphp

            <div class="mt-6">

                <div class="flex gap-1 mt-1 items-center">
                    <span class="font-bold text-lg mb-2">Ulasan Produk</span>
                    <div class="span flex items-center justify-center gap-1 mt-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= floor($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.954a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.447a1 1 0 00-.364 1.118l1.286 3.953c.3.921-.755 1.688-1.538 1.118l-3.37-2.447a1 1 0 00-1.175 0l-3.37 2.447c-.783.57-1.838-.197-1.538-1.118l1.286-3.953a1 1 0 00-.364-1.118L2.068 9.38c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.954z" />
                            </svg>
                        @endfor
                    </div>


                    <span class="text-xs text-gray-500 ml-1">
                        ({{ $totalRating }})
                    </span>
                </div>
                @if ($product->feedback->isEmpty())
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @else
                    @foreach ($product->feedback as $fb)
                        <div class=" py-2">
                            <div class="flex items-center gap-1 mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $fb->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.954a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.447a1 1 0 00-.364 1.118l1.286 3.953c.3.921-.755 1.688-1.538 1.118l-3.37-2.447a1 1 0 00-1.175 0l-3.37 2.447c-.783.57-1.838-.197-1.538-1.118l1.286-3.953a1 1 0 00-.364-1.118L2.068 9.38c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.954z" />
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-500 ml-1">{{ $fb->user->nama ?? 'Anonim' }}</span>
                            </div>
                            <p class="text-gray-700 text-sm">{{ $fb->comment }}</p>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

    </div>
    </div>
@endsection
