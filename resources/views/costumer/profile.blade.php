@extends('template')

@section('title', 'Profile')

@section('content')


    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6 text-gray-700">
        <div class="max-w-5xl w-full flex flex-col md:flex-row gap-6">
            <div
                class="w-full md:w-1/3 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col items-center">


                <form action="{{ route('costumer.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data"
                    id="photoForm1">
                    @csrf

                    <div class="relative w-32 h-32 mb-4">
                        <img id="photoPreview" onclick="openPhotoModal()"
                            src="{{ $users->gambar ? asset('images/profile/' . $users->gambar) : asset('images/profile/default.jpg') }}"
                            class="cursor-pointer rounded-full object-cover w-full h-full border-4 border-white shadow-md">


                        <input type="file" name="gambar" id="photoInput1" accept="image/*" class="hidden">

                        <label for="photoInput1"
                            class="absolute bottom-1 right-1 z-10 bg-[#b25353] p-2 rounded-full
           text-white shadow-lg hover:bg-orange-600 cursor-pointer">
                            ✏️
                        </label>

                    </div>
                </form>


                <h2 class="text-xl font-bold text-gray-800">{{ $users->nama }}</h2>

                <div class="w-full space-y-2 mt-6">
                    <a href="{{ route('costumer.profile') }}"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition cursor-pointer
   {{ request()->routeIs('costumer.profile')
       ? 'bg-[#b25353] text-white font-semibold'
       : 'text-gray-200 hover:bg-gray-50' }}">
                        <span class="text-lg">👤</span> Data akun
                    </a>
                    <a href="{{ route('costumer.profile.changePassword') }}"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition cursor-pointer
   {{ request()->routeIs('costumer.profile.changePassword')
       ? 'bg-orange-300 text-orange-700 font-semibold'
       : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-lg">🔒</span> Login & Password
                    </a>

                    <a href="#"
                        class="w-full flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-2xl transition cursor-pointer mt-4"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="text-lg">🚪</span> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>




                </div>
            </div>


            <div class="w-full md:w-2/3 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">


                <h2 class="text-2xl font-bold mb-8">Data Akun</h2>

                <form class="space-y-6" action="{{ route('costumer.update') }}" method="post">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-gray-400">Nama</label>
                            <input type="text" name="nama" value="{{ $users->nama }}"
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500">
                        </div>

                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-400">Email</label>
                        <div class="relative">
                            <input type="email" value="{{ $users->email }}" name="email"
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500">

                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="text-red-500 text-sm mt-1">
                            {{ implode(', ', $errors->all()) }}
                        </div>
                    @endif


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-gray-400">Tanggal bergabung</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $users->created_at->locale('id')->translatedFormat('d F Y') }}"
                                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500"
                                    readonly>
                                <span class="absolute right-4 top-3 text-gray-400">📅</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-gray-400">Terkhir kali update</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $users->updated_at->locale('id')->translatedFormat('d F Y') }}"
                                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500"
                                    readonly>
                                <span class="absolute right-4 top-3 text-gray-400">📅</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-gray-400">No Hp</label>
                            <input type="text" value="{{ $users->no_hp }}" name="no_hp"
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#b25353]">
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 pt-6">

                        <button type="submit"
                            class=" bg-[#b25353] w-full text-white font-bold rounded-xl hover:bg-[#b25353] shadow-lg shadow-orange-200  px-6 py-2 transition duration-200">simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="photoModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">

        <div class="relative bg-white rounded-2xl p-4 max-w-sm w-full">
            <button onclick="closePhotoModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black">
                ✕
            </button>

            <img id="modalPhoto"
                src="{{ $users->gambar ? asset('images/profile/' . $users->gambar) : asset('images/profile/default.jpg') }}"
                class="w-full h-72 object-cover rounded-xl">
            <div class="flex gap-2 items-center mt-6 w-full justify-center">
                <form action="{{ route('costumer.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data"
                    id="photoFormModal">
                    @csrf

                    <input type="file" name="gambar" id="photoInput" accept="image/*" class="hidden">

                    <button type="button" onclick="document.getElementById('photoInput').click()"
                        class="h-12 flex items-center justify-center gap-2
                       bg-[#b25353] text-white rounded-xl font-semibold
                       hover:bg-[#b25353] transition p-2">
                        ✏️edit
                    </button>
                </form>
                @if ($users->gambar)
                    <form action="{{ route('costumer.profile.deletePhoto') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus foto profile?')"
                            class="h-12 flex items-center justify-center gap-2
                       bg-[#b25353] text-white rounded-xl font-semibold
                       hover:bg-[#b25353] transition p-2">
                            🗑️hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>


    <script>
        function openPhotoModal() {
            document.getElementById('photoModal').classList.remove('hidden');
            document.getElementById('photoModal').classList.add('flex');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
            document.getElementById('photoModal').classList.remove('flex');
        }

        document.getElementById('photoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            document.getElementById('modalPhoto').src = URL.createObjectURL(file);
            document.getElementById('photoFormModal').submit();
        });
        document.getElementById('photoInput1').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            document.getElementById('photoForm1').submit();
        });
    </script>



@endsection
