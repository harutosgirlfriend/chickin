@extends('templateAdmin')

@section('content')
    <div class="col-span-1 xl:col-span-1 md:col-span-6">
        <div class="card">
            <div class="p-3 sm:p-6 bg-white shadow-lg rounded-lg">


                <div class="flex justify-between items-center mb-6 mt-2">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        Log Aktivitas
                    </h2>


                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase"> Waktu
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID User</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Produk
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Sebelum
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Sesudah
                                </th>



                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($logs as $log)
                                <tr>


                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $log->created_at->locale('id')->translatedFormat('d F Y H:i') }}

                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $log->id_user }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $log->kode_product }}
                                    </td>


                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        @if ($log->aksi == 'Tambah Produk')
                                            <span class="bg-blue-200 text-blue-800 p-2 rounded-full">Tambah Produk</span>
                                        @elseif($log->aksi == 'Tambah Stok')
                                            <span class="bg-green-200 text-green-800 p-2 rounded-full">Tambah Stok</span>
                                        @elseif($log->aksi == 'Kurangi Stok')
                                            <span class="bg-red-200 text-red-800 p-2 rounded-full">Kurangi Stok</span>
                                        @elseif ($log->aksi == 'Update Produk')
                                            <span class="bg-yellow-200 text-yellow-800 p-2 rounded-full">Update
                                                Product</span>
                                        @else
                                            <span
                                                class="bg-gray-200 text-gray-800 p-2 rounded-full">{{ $log->aksi }}</span>
                                        @endif
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $log->stok_sebelum ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $log->stok_sesudah ?? '-' }}
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
