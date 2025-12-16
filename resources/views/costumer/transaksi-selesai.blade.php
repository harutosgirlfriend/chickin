@extends('template')

@section('title', 'Berita dan Promo')

@section('content')
    <div class=" flex justify-center items-center">



        <main class=" flex flex-col items-center justify-center p-6 text-center shadow-2xl rounded-md mt-50 w-100">
            <div class="bg-green-300 rounded-full p-5"><svg id="checkmark" xmlns="http://www.w3.org/2000/svg"
                    class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg></div>


            <h2 class="text-2xl font-bold text-gray-800 mb-2 mt-5">Pesanan Anda Berhasil</h2>
            <p class="text-gray-500 mb-8">Belanja Lagi?</p>

            <div class="flex gap-2 items-center">
                <a href="{{ route('chat') }}"
                    class="hover:text-[#b25353] hover:bg-[#f0e9e9] cursor-pointer p-3 block bg-[#b25353] text-white font-semibold rounded-md text-center shadow-xl shadow-[#e4c6ba]/50 lex justify-items-center">
                    Hubungi Penjualn
                </a>
                <a href="{{ route('product') }}"
                    class="p-3 bg-red-800 hover:text-[#b25353] cursor-pointer hover:bg-[#f0e9e9] text-white font-semibold rounded-md text-center shadow-xl shadow-[#e4c6ba]/50 flex justify-items-center">
                    Belanja Lagi
                </a>
            </div>
        </main>
    </div>
    <div id="loading" class="fixed inset-0 flex flex-col items-center justify-center bg-white z-50">
        <img src="https://i.gifer.com/7efs.gif" alt="Loading..." class="w-48 mb-4">
        <p class="text-gray-700 text-lg animate-pulse">Sedang menyiapkan halaman...</p>


    </div>
    <script>
        window.addEventListener('load', () => {
            const loading = document.getElementById('loading');
            setTimeout(() => {
                loading.classList.add('hidden');
            }, 1550);
        });
    </script>
@endsection
