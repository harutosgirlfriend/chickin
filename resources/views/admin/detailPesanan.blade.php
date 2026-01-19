@extends('templateAdmin')

@section('content')
@php
    $currentStatus = $pesanan->status;
    $allSteps = ['Pending', 'Disetujui', 'Proses Pengantaran', 'Diterima'];
    $currentIndex = array_search($currentStatus, $allSteps);
    $activeColor = 'purple-600';
    $defaultColor = 'gray-300';

    $nextStatus = match ($currentStatus) {
        'Pending' => 'Disetujui',
        'Disetujui' => 'Proses Pengantaran',
        'Proses Pengantaran' => 'Diterima',
        default => null,
    };
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-2 bg-gray-100 p-10 items-stretch">
    <div class="flex flex-col h-full">
        <div class="card rounded-md bg-white p-10 shadow-lg">
            <h3 class="text-xl font-bold mb-6 text-gray-700">Status Pesanan Saat Ini</h3>

            <div class="max-w-4xl mx-auto w-full">
                <div class="flex justify-between items-start relative">
                    @foreach ($allSteps as $index => $step)
                        @php $color = $index <= $currentIndex ? $activeColor : $defaultColor; @endphp
                        <div class="text-center relative z-30 flex-1 px-2">
                            <div class="w-4 h-4 rounded-full mx-auto mb-2 bg-{{ $color }} border-2 border-{{ $color }}"></div>
                            <p class="text-xs font-medium text-{{ $color }}">{{ $step }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="max-w-sm mx-auto relative mt-8 overflow-scroll">
            @foreach ($tracking as $track)
                @php $isActive = $track->status == $currentStatus; @endphp
                <div class="flex items-start relative">
                    <div class="absolute left-3 top-0 h-full border-l-2 border-{{ $isActive ? 'purple-600' : 'gray-300' }}"></div>
                    <div class="z-10 mr-4 mt-3">
                        <div class="w-6 h-6 rounded-full bg-{{ $isActive ? 'purple-600' : 'gray-300' }} border-2 border-{{ $isActive ? 'purple-600' : 'gray-300' }}"></div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-5 mb-4 w-full">
                        <h2 class="text-lg font-bold text-gray-800">{{ $track->status }}</h2>
                        <p class="text-sm text-gray-600">Status diperbarui pada {{ $track->updated_at->locale('id')->translatedFormat('d F Y H:i')  }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class=" flex justify-center">
            @if ($nextStatus)
                <form action="{{ route('admin.pesanan.updateStatus') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kode_transaksi" value="{{ $pesanan->kode_transaksi }}">
                    <input type="hidden" name="status" value="{{ $nextStatus }}">
                    <button type="submit"
                        class="p-3 w-96 rounded-md bg-indigo-500 text-white font-semibold hover:bg-indigo-600">
                        @if ($currentStatus == 'Pending')
                            Setujui Pesanan?
                        @elseif ($currentStatus == 'Disetujui')
                            Pesanan Akan Diantar?
                        @elseif ($currentStatus == 'Proses Pengantaran')
                            Pesanan Sudah Sampai?
                        @endif
                    </button>
                </form>
            @else
                <a href="{{ route('admin.pesanan') }}"
                    class="p-3 w-96 rounded-md bg-gray-400 text-white font-semibold text-center">
                    Kembali
                </a>
            @endif
        </div>
    </div>

    <div class="card rounded-md bg-white p-3 h-screen flex flex-col">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Rincian Pesanan</h1>

        <div class="space-y-4 flex-1">
            <div class="bg-white rounded-xl shadow-md p-5">
                <h2 class="text-xl font-bold mb-2">Alamat</h2>
                @foreach ($akun as $item)
                    <p class="font-bold text-green-600">{{ $item->users->nama }}</p>
                    <p class="font-semibold text-green-600">{{ $item->users->no_hp }}</p>
                    <p class="font-semibold text-green-600">{{ $item->users->email }}</p>
                <p class="text-green-600">{{ $item->kota }}, {{ $item->kecamatan }}, {{ $item->alamat }}</p>
      
                @endforeach
            </div>

            <div class="bg-white rounded-xl shadow-md p-5">
                <h2 class="text-xl font-bold mb-4">Daftar Product</h2>
                @foreach ($products as $product)
                    <div class="flex justify-between border-b pb-3">
                        <div class="flex space-x-3">
                            <img src="{{ asset('images/product/' . $product->product->gambar) }}"
                                class="w-16 h-16 rounded-md object-cover">
                            <div>
                                <p>{{ $product->kode_product }}</p>
                                <p>{{ $product->product->nama_product }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">{{ $product->jumlah }}x</p>
                            <p>{{ $product->jumlah * $product->product->harga }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-xl shadow-md p-5">
                <h2 class="text-xl font-bold mb-2">Pembayaran</h2>
                <div class="flex justify-between">
                    <span>Total Harga</span>
                    <span>Rp{{ number_format($pesanan->total_harga) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Ongkir</span>
                    <span>Rp{{ number_format($pesanan->ongkir) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Potongan</span>
                    <span>Rp{{ number_format($pesanan->jumlah_potongan) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Metode Pembayaran</span>
                    <span>{{ $pesanan->metode_pembayaran }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>Rp{{ number_format($pesanan->total_bayar) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
