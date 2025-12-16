@extends('templateAdmin')

@section('content')
<div class="col-span-1 xl:col-span-1 md:col-span-6">
    <div class="card">
        <div class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Data Voucher</h2>
                <a href="{{ route('admin.vouchers.create') }}" 
                   class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 shadow-md">
                   Tambah Voucher
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Voucher</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Diskon</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Belanja</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mulai Berlaku</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kadaluarsa</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Diskon</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maks Diskon</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vouchers as $voucher)
                        <tr>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->kode_voucher }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->nilai_diskon }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->min_belanja }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->mulai_berlaku }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->kadaluarsa_pada ?? '-' }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->tipe_diskon }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">{{ $voucher->maks_diskon ?? '-' }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 flex space-x-2">
                                <a href="{{ route('admin.vouchers.edit', $voucher->kode_voucher) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('admin.vouchers.destroy', $voucher->kode_voucher) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus voucher ini?')">Hapus</button>
                                </form>
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
