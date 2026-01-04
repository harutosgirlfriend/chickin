@extends('template')

@section('title', 'Detail Pesanan')

@section('content')

    @php
        $currentStatus = $pesanan->status;
        $allSteps = ['Pending', 'Disetujui', 'Proses Pengantaran', 'Diterima'];
        $currentIndex = array_search($currentStatus, $allSteps);

        $statusColor = [
            'Pending' => 'text-blue-600',
            'Disetujui' => 'text-indigo-600',
            'Proses Pengantaran' => 'text-yellow-600',
            'Diterima' => 'text-green-600',
        ];

        $statusBg = [
            'Pending' => 'bg-blue-600 border-blue-600',
            'Disetujui' => 'bg-indigo-600 border-indigo-600',
            'Proses Pengantaran' => 'bg-yellow-600 border-yellow-600',
            'Diterima' => 'bg-green-600 border-green-600',
        ];

        $nextStatus = match ($currentStatus) {
            'Pending' => 'Disetujui',
            'Disetujui' => 'Proses Pengantaran',
            'Proses Pengantaran' => 'Diterima',
            default => null,
        };
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 bg-gray-100 p-10 min-h-screen">
        <div class="flex flex-col h-full justify-between">
            <div>
                <div class="bg-white p-10 rounded-md shadow-lg">
                    <h3 class="text-xl font-bold mb-6 text-gray-700">Status Pesanan Saat Ini</h3>

                    <div class="flex justify-between">
                        @foreach ($allSteps as $index => $step)
                            @php $active = $index <= $currentIndex; @endphp
                            <div class="flex-1 text-center">
                                <div
                                    class="w-4 h-4 rounded-full mx-auto mb-2 border-2
                                {{ $active ? $statusBg[$step] : 'bg-gray-300 border-gray-300' }}">
                                </div>
                                <p
                                    class="text-xs font-medium
                                {{ $active ? $statusColor[$step] : 'text-gray-400' }}">
                                    {{ $step }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="max-w-sm mx-auto mt-8 overflow-y-auto">
                    @foreach ($tracking as $track)
                        @php $active = $track->status === $currentStatus; @endphp
                        <div class="flex relative mb-4">
                            <div
                                class="absolute left-3 top-0 h-full border-l-2
                            {{ $active ? 'border-indigo-600' : 'border-gray-300' }}">
                            </div>
                            <div class="mr-4 mt-2 z-10">
                                <div
                                    class="w-6 h-6 rounded-full border-2
                                {{ $active ? 'bg-indigo-600 border-indigo-600' : 'bg-gray-300 border-gray-300' }}">
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded shadow w-full">
                                <h2 class="font-bold">{{ $track->status }}</h2>
                                <p class="text-sm text-gray-600">
                                    {{ $track->updated_at->locale('id')->translatedFormat('d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-auto flex justify-center">
                @if ($currentStatus === 'Proses Pengantaran')
                    <form action="{{ route('admin.pesanan.updateStatus') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_transaksi" value="{{ $pesanan->kode_transaksi }}">
                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                        <button class="w-96 p-3 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Pesanan Sudah Sampai?
                        </button>
                    </form>
                @elseif ($currentStatus === 'Diterima')
                    <a href="{{ route('order.rate', $pesanan->kode_transaksi) }}"
                        class="w-96 p-3 bg-green-600 text-white text-center rounded hover:bg-green-700">
                        Beri Penilaian
                    </a>
                @elseif($nextStatus)
                    <a onclick="history.back()" class="w-96 p-3 bg-gray-400 text-white text-center rounded">
                        Kembali
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-white p-5 rounded-md shadow h-full">
            <h1 class="text-2xl font-bold mb-4">Rincian Pesanan</h1>

            <div class="space-y-4">
                <div class="bg-white p-5 rounded shadow">
                    <h2 class="font-bold mb-2">Alamat</h2>
                    @foreach ($akun as $item)
                        <p class="font-bold text-green-600">{{ $item->users->nama }}</p>
                        <p class="text-green-600">{{ $item->kota }}</p>
                        <p class="text-green-600">{{ $item->kecamatan }}</p>
                        <p class="text-green-600">{{ $item->alamat }}</p>
                    @endforeach
                </div>

                <div class="bg-white p-5 rounded shadow">
                    <h2 class="font-bold mb-4">Daftar Product</h2>
                    @foreach ($products as $product)
                        <div class="flex justify-between pb-3 mb-2">
                            <div class="flex space-x-3">
                                <img src="{{ asset('images/product/' . $product->product->gambar) }}"
                                    class="w-16 h-16 rounded object-cover">
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

                <div class="bg-white p-5 rounded shadow">
                    <h2 class="font-bold mb-2">Pembayaran</h2>
                    <div class="flex justify-between"><span>Total
                            Harga</span><span>Rp{{ number_format($pesanan->total_harga) }}</span></div>
                    <div class="flex justify-between">
                        <span>Ongkir</span><span>Rp{{ number_format($pesanan->ongkir) }}</span>
                    </div>
                    <div class="flex justify-between"><span>Metode</span><span>{{ $pesanan->metode_pembayaran }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span><span>Rp{{ number_format($pesanan->total_bayar) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
