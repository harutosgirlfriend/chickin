@extends('templateAdmin')



@section('content')
    <div class="col-span-1 xl:col-span-1 md:col-span-6">
        <div class="card">
            <div class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">

                <div class="flex justify-between items-center mb-6">

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        Data Pesanan
                    </h2>
                    {{-- <div class="flex space-x-3">
                        <div class="flex input-group w-50 rounded-md border-2 px-2">
                            <div class="icon flex items-center">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <input id="liveSearch" class="form-control border-none" type="text" name="keyword"
                                placeholder="Cari Produk" value="">
                        </div>
                        <button data-bs-toggle="modal" data-bs-target="#modalTambahProduct"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md">
                            Tambah Product
                        </button>
                    </div> --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Kode Transaksi
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Tanggal <span class="ml-1 text-gray-400">↑</span>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Total Harga <span class="ml-1 text-gray-400">↑</span>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Total Bayar <span class="ml-1 text-gray-400">↑</span>
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900">
                                    Status <span class="ml-1 text-gray-400">↑</span>
                                </th>

                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                    Jumlah Product
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                    AKSI
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">


                            @foreach ($pesanan as $pesan)
                                @php
                                    $kode_transaksi = $pesan->kode_transaksi;
                                    $daftar_produk = $product[$kode_transaksi] ?? null;
                                       $status_transaksi = $pesan->status ?? 'Status Default'; 
                                    $status_class = match ($status_transaksi) {
                                        'Proses Pengantaran' => 'bg-green-500 text-gray',
                                        'Pending' => 'bg-blue-200 text-gray',
                                        'Ditolak' => 'bg-red-200 text-gray',
                                        default => 'bg-gray-200 text-gray',
                                    };
                                @endphp
                                <tr>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pesan->kode_transaksi }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $pesan->tanggal }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $pesan->total_harga }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $pesan->total_bayar }}
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        <span  class="py-2 px-3 inline-flex text-xs leading-5 font-semibold rounded-full  {{ $status_class }}">     {{ $pesan->status }}</span>
                                   
                                    </td>
                            
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ count($daftar_produk) }} Product
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <a href="{{ route('admin.pesanan.detail', $pesan->kode_transaksi) }}" class="text-blue-600 hover:text-blue-900 flex p-2" title="Detail">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg> Detail
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@endsection
