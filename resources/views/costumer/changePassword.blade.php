@extends('template')

@section('title', 'Login & Password')

@section('content')


    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6 text-gray-700">
        <div class="max-w-5xl w-full flex flex-col md:flex-row gap-6">

            <div
                class="w-full md:w-1/3 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col items-center">
                <div class="relative w-32 h-32 mb-4">
                    <img src="{{ auth()->user()->gambar ? asset('images/profile/' . auth()->user()->gambar) : asset('images/profile/default.jpg') }}"
                        alt="Profile" class="rounded-full object-cover w-full h-full border-4 border-white shadow-md">

                </div>

                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->nama }}</h2>


                <div class="w-full space-y-2">
                    <a href="{{ route('costumer.profile') }}"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition cursor-pointer
   {{ request()->routeIs('costumer.profile')
       ? 'bg-orange-100 text-orange-700 font-semibold'
       : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-lg">👤</span> Data akun
                    </a>
                    <a href="{{ route('costumer.profile.changePassword') }}"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition cursor-pointer
   {{ request()->routeIs('costumer.profile.changePassword')
       ? 'bg-orange-300 text-orange-700 font-semibold'
       : 'text-gray-500 hover:bg-gray-50' }}">
                        <span class="text-lg">🔒</span> Login & Password
                    </a>

                    <a href="{{ route('logout') }}"
                        class="w-full flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-2xl transition cursor-pointer mt-4">
                        <span class="text-lg">🚪</span> Log Out
                    </a>
                </div>
            </div>

            <div class="w-full md:w-2/3 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-2xl font-bold mb-8">Ubah Password</h2>


                <form method="POST" action="{{ route('costumer.profile.ubahPassword') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Sekarang<span
                                    class="text-red-500">*</span></label>
                            <input type="password" name="password_lama" value=""
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>


                            @if ($errors->any())
                                <div class="text-red-500 text-sm mt-1">
                                    {{ implode(', ', $errors->all()) }}
                                </div>
                            @endif

                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru<span
                                    class="text-red-500">*</span></label>
                            <input type="password" name="password" value=""
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('password')
                                <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru<span
                                    class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" value=""
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-8">
                        <a href="{{ route('costumer.profile') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200 mr-3">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit"
                            class=" bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 shadow-lg shadow-orange-200  px-6 py-2 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection
