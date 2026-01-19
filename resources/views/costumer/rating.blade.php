@extends('template')

@section('title', 'Beri Penilaian')

@section('content')
    <div class="max-w-3xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">Beri Penilaian Produk</h1>
        @foreach ($products as $item)
            @php

                $alreadyRated = \App\Models\Fedbacks::where('id_user', auth()->id())
                    ->where('kode_transaksi', $item->kode_transaksi)
                    ->where('kode_product', $item->product->kode_product)
                    ->exists();

            @endphp

            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="font-semibold">
                    {{ $item->product->nama_product }}
                </h2>

                @if ($alreadyRated)
                    <p class="text-green-600">✔ Sudah diberi penilaian</p>
                @else
                    <form enctype="multipart/form-data"
                        action="{{ route('product.rate', [$item->kode_transaksi, $item->product->kode_product]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="flex gap-1 star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden">
                                    <svg class="w-8 h-8 star text-gray-300" data-value="{{ $i }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.954a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.447a1 1 0 00-.364 1.118l1.286 3.953c.3.921-.755 1.688-1.538 1.118l-3.37-2.447a1 1 0 00-1.175 0l-3.37 2.447c-.783.57-1.838-.197-1.538-1.118l1.286-3.953a1 1 0 00-.364-1.118L2.068 9.38c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.954z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                        @enderror
                        <textarea name="komentar" class="w-full border rounded p-2 mt-2" placeholder="Tulis ulasan..."></textarea>
                        @error('komentar')
                            <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                        @enderror
                        <label class="block mt-2">
                            Upload Foto (opsional):
                            <input type="file" name="foto[]" class="border p-2 rounded w-full" multiple>
                        </label>
                        @error('foto.*')
                            <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                        @enderror
                        <button class="bg-yellow-500 px-4 py-2 mt-3 text-white rounded">Kirim Rating</button>
                    </form>
                @endif
            </div>
        @endforeach

    </div>


    <script>
        document.querySelectorAll('.star-rating').forEach(box => {
            const stars = box.querySelectorAll('.star');
            const radios = box.querySelectorAll('input[type=radio]');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    radios[index].checked = true;

                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });
        });
    </script>


@endsection
