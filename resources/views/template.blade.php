<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @livewireStyles

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    @vite(['resources/css/style.css', 'resources/js/app.js', 'resources/js/script.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @media (max-width: 600px) {
            .hero-section {
                height: 600px;
                background-image: url('/images/hero-mobile.svg');
            }

        }

        @media (min-width: 601px) {
            .hero-section {
                background-image: url('/images/hero-md.svg');
                height: 500px;
            }

        }

        @media (min-width: 1024px) {
            .hero-section {
                background-image: url('/images/hero-lg.svg');
                height: 680px;
            }

        }

        .wawan {
            font-family: "Playfair Display", serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }

        .ap-sj,
        .top-pro {
            font-family: "Gravitas One", serif;
            font-weight: 400;
            font-style: normal;
        }

        .tombol {
            font-family: "Gravitas One", serif;
            font-weight: <weight>;
            font-style: bold;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col  w-auto">

    <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> -->
    <nav class="bg-[#ffffff] relative rounded-md shadow-xl shadow-black-300/50">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" command="--toggle" commandfor="mobile-menu"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500 menu">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center  sm:items-stretch sm:justify-start">
                    <div class="flex shrink-0 items-center">
                        <img src="{{ asset('../images/logo.png') }}" alt="Your Company" class="h-15 w-auto" />
                    </div>
                    <div class="hidden sm:ml-6 lg:pl-60 h-15 lg:flex items-center sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                            <a href="{{ route('dashboard') }}" aria-current="page"
                                class="tombol px-3 py-2 text-md font-bold hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353]  text-[#a01800] {{ request()->routeIs('dashboard') ? 'pb-2  border-b-4 border-[#b25353]  text-[#a01800] shadow-2xl' : 'text-[#a01800] hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353] ' }}">Dashboard</a>
                            <a href="{{ route('product') }}"
                                class="tombol px-3 py-2 text-md font-bold hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353]  text-[#a01800] {{ request()->routeIs('product') ? 'pb-2  border-b-4 border-[#b25353]  text-[#a01800] shadow-2xl' : 'text-[#a01800] hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353] ' }}">Produk</a>
                            @auth
                                <a href="{{ route('chat') }}"
                                    class="tombol px-3 py-2 text-md font-bold hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353]  text-[#a01800] {{ request()->routeIs('chat') ? 'pb-2 border-b-4 border-[#b25353] text-[#a01800] shadow-2xl' : 'text-[#a01800]' }}">
                                    Pesan
                                </a>
                                <a href="{{ route('pesanan') }}"
                                    class="tombol px-3 py-2 text-md font-bold hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353]  text-[#a01800] {{ request()->routeIs('pesanan') ? 'pb-2  border-b-4 border-[#b25353]  text-[#a01800] shadow-2xl' : 'text-[#a01800] hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353] ' }}">Pesanan</a>
                                @if (auth()->user()->role !== 'admin')
                                    <livewire:chat-notification />
                                @endif
                            @endauth



                            <!-- Include this script tag or install `@tailwindplus/elements` via npm: -->

                            <el-dropdown class="inline-block">
                                <button
                                    class="tombol px-3 py-2 text-md font-bold hover:pb-2 flex hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353]  text-[#a01800] {{ request()->routeIs('product.kategori') ? 'pb-2  border-b-4 border-[#b25353]  text-[#a01800] shadow-2xl' : 'text-[#a01800] hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353] ' }}">
                                    Kategori
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="-mr-1 size-5 text-gray-400 tombol">
                                        <path
                                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                </button>

                                <el-menu anchor="bottom end" popover
                                    class="w-56 origin-top-right rounded-md bg-white shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                                    <div class="py-1">
                                        <a href="{{ route('product.kategori', ['kategori' => 'ayam hidup']) }}"
                                            class="block px-4 py-2 text-md font-bold text-[#a01800] focus:bg-gray-100 focus:text-gray-900 focus:outline-hidden ayamhiddup">Ayam
                                            Hidup</a>
                                        <p class="submenu hidden mx-5"> ayammm</p>
                                        <a href="{{ route('product.kategori', ['kategori' => 'ayam potong']) }}"
                                            class="block px-4 py-2 text-md font-bold text-[#a01800] focus:bg-gray-100 focus:text-gray-900 focus:outline-hidden">Ayam
                                            Potong</a>
                                        <a href="{{ route('product.kategori', ['kategori' => 'telur']) }}"
                                            class="block px-4 py-2 text-md font-bold text-[#a01800] focus:bg-gray-100 focus:text-gray-900 focus:outline-hidden">Telur
                                            Ayam</a>
                                    </div>
                                </el-menu>
                            </el-dropdown>


                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <button type="button" class="relative rounded-full p-1 text-gray-100 keranjang">

                        <svg viewBox="0 0 24 24" fill="none" stroke="#b25353" stroke-width="2" data-slot="icon"
                            aria-hidden="true" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 2.25h1.386c.51 0 .956.343 1.09.835l.383 1.435M7.5 14.25h9.75m-9.75 0L6 6.75h12.75a.75.75 0 0 1 .735.91l-1.5 6a.75.75 0 0 1-.735.59H7.5zm0 0L6 6.75m1.5 7.5L5.25 18a.75.75 0 0 0 .75 1h12a.75.75 0 0 0 .75-1l-2.25-3.75" />
                        </svg>
                        @auth
                            <span id="cart-badge"
                                class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold rounded-full px-1.5 hidden">
                                {{ (string) $total_item }}
                            </span>
                        @endauth

                    </button>
                    @auth
                        <el-dropdown class="relative ml-3">
                            <button
                                class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 ">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt=""
                                    class="size-8 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                            </button>

                            <el-menu anchor="bottom end" popover
                                class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">

                                @auth
                                    <a href="{{ route('chat') }}"
                                        class="tombol px-3 py-2 text-md font-bold hover:pb-2 hover:text-[#b25353] hover:border-b-4 hover:border-[#b25353]  text-[#a01800] {{ request()->routeIs('chat') ? 'pb-2 border-b-4 border-[#b25353] text-[#a01800] shadow-2xl' : 'text-[#a01800]' }}">
                                        Pesan
                                    </a>

                                    @if (auth()->user()->role !== 'admin')
                                        <livewire:chat-notification />
                                    @endif
                                @endauth

                                <a href="#"
                                    class="block px-4 py-2 text-sm font-bold text-[#a01800] focus:bg-gray-100 focus:outline-hidden hover:text-[#b25353] hover:bg-[#f0e9e9]">Settings</a>
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm font-bold text-[#a01800] focus:bg-gray-100 focus:outline-hidden hover:text-[#b25353] hover:bg-[#f0e9e9]">Sign
                                    out</a>
                            </el-menu>
                        </el-dropdown>
                    @endauth
                    @guest
                        <a href="{{ route('login.view') }}"
                            class="text-[#b25353] px-6 py-3 block font-bold justify-self-center rounded-md shadow-xl shadow-[#e4c6ba]/50 hover:text-[#b25353] hover:bg-[#f0e9e9]">Login</a>

                    @endguest
                    <!-- Profile dropdown -->

                </div>
            </div>
        </div>

        <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                <a href="{{ route('dashboard') }}" aria-current="page"
                    class="tombol block rounded-md font-bold text-[#a01800]  px-3 py-2 text-base  hover:text-[#b25353] hover:bg-[#f0e9e9]">Dashboard</a>
                <button type="button"
                    class="toggle-products flex w-full items-center justify-between rounded-lg py-2 pr-3.5 pl-3 text-base/7 font-bold text-[#a01800] hover:text-[#b25353] hover:bg-[#f0e9e9]">
                    Product
                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                        class="size-5 flex-none in-aria-expanded:rotate-180">
                        <path
                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </button>
                <div id="products" hidden class="mt-2 block space-y-2">
                    <a href="{{ route('product.kategori', ['kategori' => 'ayam hidup']) }}"
                        class="tombol block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-bold text-[#a01800] hover:text-white">Ayam
                        Hidup</a>
                    <a href="{{ route('product.kategori', ['kategori' => 'ayam potong']) }}"
                        class="tombol block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-bold text-[#a01800] hover:text-white">Ayam
                        Potong</a>
                    <a href="{{ route('product.kategori', ['kategori' => 'telur']) }}"
                        class="tombol block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-bold text-[#a01800] hover:text-white">Telur
                        Ayam</a>

                </div>
                <a href="{{ route('pesanan') }}" aria-current="page"
                    class="tombol block rounded-md font-bold text-[#a01800]  px-3 py-2 text-base  hover:text-[#b25353] hover:bg-[#f0e9e9]">Pesanan</a>

            </div>
        </el-disclosure>
    </nav>
    <div id="keranjang-container"
        class="fixed top-8 right-0 z-50 w-full md:w-1/3 h-screen bg-white shadow-2xl transform translate-x-full transition-transform duration-300 hidden">
        <div class="shadow-md rounded p-10 w-full">
            <div class="icon-silang flex justify-between">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <h2 class="text-lg font-semibold">Keranjang Anda</h2>
            </div>

            <form id="checkout-form" action="@auth {{ route('checkout.auth') }} @endauth" method="POST">
                @csrf

                <div class="flex items-center gap-2 mt-4 mb-2">
                    <input type="checkbox" id="select-all" class="w-4 h-4 cursor-pointer">
                    <label for="select-all" class="text-sm font-medium cursor-pointer">Pilih Semua</label>
                </div>

                <div class="list overflow-auto h-[60vh]">
                    <div class="space-y-4 isi-keranjang">
                        @auth
                            @foreach ($keranjang as $item)
                                <div class="flex items-center justify-between border-b pb-3"
                                    id="keranjangno{{ $item->id }}">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox" id="checkbox{{ $item->id }}"
                                            class="item-checkbox w-4 h-4 {{ $item->product->stok <= 0 || $item->product->stok < $item->jumlah ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}"
                                            data-id="{{ $item->id }}" data-harga="{{ $item->product->harga }}"
                                            data-jumlah="{{ $item->jumlah }}"
                                            @if ($item->product->stok <= 0 || $item->product->stok < $item->jumlah) disabled @endif>
                                        <div class="relative">
                                            <img src="{{ asset('images/product/' . $item->product->gambar) }}"
                                                alt="Produk" class="w-16 h-16 rounded-md object-cover">
                                            @if ($item->product->stok <= 0)
                                                <div class="absolute bottom-0 left-0 w-16 h-5 bg-black bg-opacity-10 text-white text-center text-xs"
                                                    style="background-color: rgba(0, 0, 0, 0.5);">
                                                    stok habis
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $item->product->nama_product }}</p>
                                            <p class="text-sm text-gray-600">Rp {{ number_format($item->product->harga) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if ($item->product->stok < $item->jumlah)
                                            <p class="text-gray-600" id="status-stok{{ $item->id }}">
                                                Stok tidak mencukupi
                                            </p>
                                        @endif

                                        <div class="flex items-center">
                                            <button type="button"
                                                class="kurangiKer border border-gray-400 px-1 py-1 mx-0"
                                                data-id="{{ $item->id }}"
                                                @if ($item->product->stok <= 0) disabled @endif>-</button>
                                            <span class="jumlahKer border-y border-gray-400 px-1 py-1 mx-0"
                                                id="jumlahKer{{ $item->id }}"
                                                data-id="{{ $item->id }}">{{ $item->jumlah }}</span>
                                            <button type="button" class="tambahKer border border-gray-400 px-1 py-1 mx-0"
                                                data-jumlah="{{ $item->jumlah }}" data-id="{{ $item->id }}"
                                                data-stok="{{ $item->product->stok }}">+</button>
                                        </div>

                                        <p class="text-gray-600 subtotal" id="sub{{ $item->id }}">
                                            Rp {{ number_format($item->jumlah * $item->product->harga) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endauth

                    </div>
                </div>


                <div class="mt-6 border-t pt-4">
                    <div class="flex justify-between text-lg font-semibold mb-3">
                        <span>Total</span>
                        <span id="total-display">Rp 0</span>
                    </div>

                    <input type="hidden" id="total-input" name="total" value="0">
                    <input type="hidden" id="selected-items" name="selected_items" value="[]">

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition checkout">
                        Checkout
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div>
    </div>

    <main class="flex-1 overflow-hidden">
        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Oops!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @yield('content')
    </main>




    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    @livewireScripts


</body>


</html>
