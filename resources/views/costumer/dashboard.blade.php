@extends('template')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full lg:h-[500px] bg-cover bg-center hero-section">

        <div class="relative z-10  grid lg:grid-cols-2 h-full">
            <div class="card px-30 py-30">
                <h1 class="text-4xl font-bold  text-[#a01800] wawan">CHICKin</h1>
                <p>Toko ayam pesan antar melayani wilayah Kota Pekalongan untuk semua kecamatan serta Kabupaten Batang
                    khusus Kecamatan Batang dan Kandeman. Pesanan di luar wilayah tersebut tetap bisa dilakukan dengan
                    pengambilan langsung di store.</p>

            </div>

        </div>

    </div>
    <div class="flex flex-col justify-center items-center ">
        <h1 class="text-4xl font-bold mb-10  text-[#a01800] ap-sj">Ada Apa Saja Disini?</h1>
        <div class="best-product flex flex-row justify-center gap-10 py-10 best-pro md:w-full">

            <div
                class="rounded-md bg- justify-items-center w-70 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/kategori-telurAyam.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Telur Ayam Negeri </li>
                    <p class="py-2 px-3">Telur ayam segar pilihan dari peternakan terbaik. Kaya akan protein dan nutrisi
                        esensial, cocok untuk segala kebutuhan dapur Anda, mulai dari membuat kue hingga lauk pauk
                        sehari-hari. Warna cangkang cokelat alami, menandakan kualitas dan kesegaran yang terjamin.</p>
                    <a href="{{ route('product.kategori', ['kategori' => 'telur']) }}"
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</a>

                </ul>
            </div>


            <div
                class="rounded-md bg- justify-items-center w-70 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/kategori-ayamHidup.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Ayam Negeri </li>
                    <p class="py-2 px-3">Ayam hidup berkualitas tinggi, dipelihara dengan pakan bernutrisi dan dikandang
                        yang bersih. Berat standar, sehat, dan siap potong. Pilihan ideal untuk Anda yang membutuhkan ayam
                        segar dengan jaminan kehalalan dan kualitas unggul langsung dari sumbernya.</p>
                    <a href="{{ route('product.kategori', ['kategori' => 'ayam hidup']) }}"
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</a>

                </ul>
            </div>
            {{-- <div
                class="rounded-md bg- justify-items-center w-70 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/kategori-ayamHidup.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Telor Bebek </li>
                    <p class="py-2 px-3">Ayam hidup berkualitas tinggi, dipelihara dengan pakan bernutrisi dan dikandang
                        yang bersih. Berat standar, sehat, dan siap potong. Pilihan ideal untuk Anda yang membutuhkan ayam
                        segar dengan jaminan kehalalan dan kualitas unggul langsung dari sumbernya.</p>
                    <a href="{{ route('product.kategori', ['kategori' => 'ayam hidup']) }}"
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</a>

                </ul>
            </div> --}}


            <div
                class="rounded-md bg- justify-items-center w-70 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/best-product2.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Ayam Potong </li>
                    <p class="py-2 px-3">Daging ayam potong segar dengan tekstur lembut dan bersih. Siap masak, sudah
                        dipotong menjadi bagian-bagian utama (dada, paha, sayap) untuk memudahkan Anda dalam menyiapkan
                        hidangan. Diproses secara higienis dan dikemas rapi untuk menjaga kesegarannya.</p>
                    <a href="{{ route('product.kategori', ['kategori' => 'ayam potong']) }}"
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</a>

                </ul>
            </div>

        </div>
    </div>
    <div class="about header-2  w-full bg-cover bg-[#e4c6ba] shadow-xl shadow-[#e4c6ba]/70 rounded-md">
        <div
            class="aboutView grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 lg:h-[400px] gap-2 items-center transform translate-y-full transition-transform duration-1000 hidden">
            <p class="px-10 py-3">Bermula dari peternakan kecil skala rumahan di Batang Kandeman, memberikan layanan pesan
                antar untuk wilayah Batang-Pekalongan</p>

            <img src="{{ asset('../images/animasi-ayam.gif') }}" alt=""
                class="object-cover rounded px-10 py-3 block mx-auto">

            <p class="px-10 py-3">Dengan harga terjangkau dan daging segar, kami berani menjamin kepuasan anda</p>
        </div>

    </div>

    {{-- <div class="flex flex-col justify-center items-center p-10">
        <h1 class="text-4xl font-bold text-[#a01800] mb-10 top-pro">Top 4 Product</h1>
        <div class="best-product flex flex-row justify-center gap-10 py-10  md:w-full">

            <div
                class="rounded-md bg- justify-items-center w-60 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/best-product2.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Stok </li>
                    <p class="py-2 px-3">Ayam Negeri 1/2 Kg
                    </p>
                    <button
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</button>

                </ul>
            </div>

            <div
                class="rounded-md bg- justify-items-center w-60 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/best-product2.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Stok </li>
                    <p class="py-2 px-3">Telur Ayam Negeri
                    </p>
                    <button
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</button>

                </ul>
            </div>


            <div
                class="rounded-md bg- justify-items-center w-60 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer">

                <img src="{{ asset('../images/best-product2.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Stok </li>
                    <p class="py-2 px-3">Ayam potong paha
                    </p>
                    <button
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</button>

                </ul>
            </div>


            <div
                class="rounded-md bg- justify-items-center w-60 shadow-xl shadow-[#e4c6ba]/50 p-5 hover:scale-110 hover:cursor-pointer slide-out">

                <img src="{{ asset('../images/best-product2.jpg') }}" alt="" class="object-cover rounded w-70">

                <ul>



                    <li class="px-2 py-3 font-semibold text-center">Stok </li>
                    <p class="py-2 px-3">Ayam Potong Dada
                    </p>
                    <button
                        class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-2 py-3 block bg-[#b25353] text-white font-semibold rounded-md justify-self-center shadow-xl shadow-[#e4c6ba]/50">Beli
                        Sekarang</button>

                </ul>
            </div>

        </div>
    </div> --}}
    <h1 class="text-4xl font-bold text-[#a01800] mb-10 top-pro text-center">Product Kami</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-stretch p-10 ">

        @foreach ($product as $p)
            <a href="{{ route('detail', ['kode_product' => $p->kode_product]) }}">

                <div class="card rounded-md bg-white p-2 shadow-xl shadow-[#e4c6ba]/50 flex flex-col h-90">
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
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quas ipsa consequatur sed dicta
                                accusantium dolorum molestiae facilis et sequi nam mollitia ipsum nesciunt odio quod ex
                                aliquid, architecto quae suscipit.</p>
                        </div>

                        <div class="text-center flex items-center gap-2">
                            <p class="text-sm font-bold"> Rp {{ number_format($p->harga) }}</p>

                            <button
                                class="hover:text-[#b25353] hover:bg-[#f0e9e9] px-3 py-1 block bg-[#b25353] text-white font-semibold rounded-md text-center shadow-xl shadow-[#e4c6ba]/50">
                                Detail
                            </button>
                        </div>
                    </div>


                </div>
            </a>
        @endforeach


    </div>


    <footer class="bg-[#e4c6ba] text-[#5a1a0c] mt-20 shadow-xl shadow-[#e4c6ba]/70 rounded-md">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Brand --}}
            <div>
                <h2 class="text-2xl font-bold text-[#a01800] mb-2">CHICKin</h2>
                <p class="text-sm leading-relaxed">
                    Toko ayam pesan antar melayani wilayah Kota Pekalongan dan Kabupaten Batang
                    dengan ayam segar langsung dari peternakan.
                </p>
            </div>

            {{-- Lokasi --}}
            <div>
                <h3 class="text-lg font-semibold text-[#a01800] mb-3">Lokasi Toko</h3>
                <p class="text-sm mb-3">
                    Batang, Kandeman – Jawa Tengah
                </p>

                <a href="https://maps.app.goo.gl/7uvj2ud7V2YfKDRLA?g_st=aw" target="_blank"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-[#b25353] px-4 py-2 rounded-md shadow-lg hover:bg-[#a01800] transition">

                    {{-- Icon Maps --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
                    </svg>

                    Lihat di Google Maps
                </a>
            </div>

            {{-- Social Media --}}
            <div>
                <h3 class="text-lg font-semibold text-[#a01800] mb-3">Ikuti Kami</h3>
                <div class="flex gap-4">
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/USERNAME_KAMU" target="_blank"
                        class="text-white hover:text-[#f0e9e9] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="5" ry="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.5" cy="6.5" r="1" />
                        </svg>
                    </a>

                    <!-- Twitter -->
                    <a href="https://twitter.com/USERNAME_KAMU" target="_blank"
                        class="text-white hover:text-[#f0e9e9] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53A4.48 4.48 0 0 0 12.07 8v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                        </svg>
                    </a>
                </div>

            </div>

        </div>

        <div class="bg-[#b25353] text-white text-center text-sm py-3 shadow-inner">
            © {{ date('Y') }} CHICKin. All rights reserved.
        </div>
    </footer>


@endsection
