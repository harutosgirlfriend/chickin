@extends('template')

@section('title', 'Daftar Produk')

@section('content')
        @if ($product->isNotEmpty())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-stretch p-10 ">

            @foreach ($product as $p)
                @php
                    $feedbacks = $p->feedback ?? collect();
                    $avgRating = round($feedbacks->avg('rating') ?? 0, 1);
                    $totalRating = $feedbacks->count();
                @endphp


                <div>
                    <div class="card rounded-md bg-white p-3 shadow-xl shadow-[#e4c6ba]/50 flex flex-col h-95">
                        <div class="relative">
                            <img src="{{ asset('images/product/' . $p->gambar) }}" alt="{{ $p->nama_product }}"
                                class="object-cover rounded">

                            <?php if ($p->stok <= 0): ?>
                            <div class="absolute bottom-0 left-0 w-full py-2 bg-black bg-opacity-1 text-white text-center font-bold text-lg z-10"
                                style="background-color: rgba(0, 0, 0, 0.5);">
                                stok habis
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-auto flex flex-col items-center justify-center">
                            <div class="text-center px-2 w-40">
                                <p class="text-[#b25353] font-extrabold text-lg">
                                    {{ $p->nama_product }}
                                </p>

                                <p class="text-sm font-bold"> Rp {{ number_format($p->harga) }}</p>

                                <p
                                    class="text-sm font-medium overflow-hidden whitespace-nowrap text-ellipsis max-w-full line-clamp-2">
                                    {{ $p->deskripsi }}
                                </p>
                            </div>

                            <div class="text-center flex items-center gap-2">

                                <div class="flex items-center justify-center gap-1 mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= floor($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.954a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.447a1 1 0 00-.364 1.118l1.286 3.953c.3.921-.755 1.688-1.538 1.118l-3.37-2.447a1 1 0 00-1.175 0l-3.37 2.447c-.783.57-1.838-.197-1.538-1.118l1.286-3.953a1 1 0 00-.364-1.118L2.068 9.38c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.954z" />
                                        </svg>
                                    @endfor

                                    <span class="text-xs text-gray-500 ml-1">
                                        ({{ $totalRating }})
                                    </span>
                                </div>

                                <a href="{{ route('detail', ['kode_product' => $p->kode_product]) }}"
                                    class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-3 py-1 block bg-[#b25353] text-white font-semibold rounded-md text-center shadow-xl shadow-[#e4c6ba]/50">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
     
    </div>
       @else
            <div class="flex w-full flex-col items-center justify-center p-6 text-center ">
                <div class="w-1/4">
                <div class="mb-8 p-4 w-full rounded-lg relative">
                    <div
                        class="w-full h-40 flex flex-col items-center justify-center  relative">
                        <div class="w-full h-40 bg-orange-300 rounded-t-lg -mt-4 relative transform -rotate-2 shadow-inner">
                            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-orange-200"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="flex space-x-3 mt-4">
                                    <div class="w-1 h-1 bg-gray-600 rounded-full"></div>
                                    <div class="w-1 h-1 bg-gray-600 rounded-full"></div>
                                </div>
                                <div class="w-4 h-0.5 bg-gray-600 rounded-full mt-1.5 transform rotate-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-1 -left-1 text-yellow-500 text-2xl transform rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3s4 0 7 7c3-7 7-7 7-7m-7 7v11" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-2">Produk tidak tersedia</h2>
              

                </div>
            </div>
        @endif
@endsection
