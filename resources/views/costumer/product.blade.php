@extends('template')

@section('title', 'Daftar Produk')

@section('content')
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-stretch p-10 ">

        @foreach ($product as $p)
            <div>

                <div class="card rounded-md bg-white p-3 shadow-xl shadow-[#e4c6ba]/50 flex flex-col h-95">
                    <div class="relative">
                        <img src="{{ asset('images/product/' . $p->gambar) }}" alt="{{ $p->nama_product }}"
                            class="object-cover rounded">
                        <?php if ($p->stok <=0 ): ?>
                        <div class="absolute bottom-0 left-0 w-full py-2 bg-black bg-opacity-1 text-white text-center font-bold text-lg z-10"
                            style="background-color: rgba(0, 0, 0, 0.5);">
                            stok habis
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-auto flex flex-col items-center justify-center">
                        <div class="text-center px-2 w-40">
                            <p class="text-[#b25353] font-extrabold text-lg">{{ $p->nama_product }}</p>

                            <p
                                class="text-sm font-medium overflow-hidden whitespace-nowrap text-ellipsis max-w-full line-clamp-2">
                                {{ $p->deskripsi }}
                               </p>
                        </div>

                        <div class="text-center flex items-center gap-2">

                            <p class="text-sm font-bold"> Rp {{ number_format($p->harga) }}</p>

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


@endsection
