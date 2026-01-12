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
                <div class="flex mx-auto justify-end">
                    <form method="GET" class="flex flex-wrap gap-3 mb-4">

                        <div>
                            <label class="text-sm text-gray-600">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="border rounded-md px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="border rounded-md px-3 py-2 text-sm">
                        </div>

                        <div class="flex items-end gap-2">

                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                Cari
                            </button>

                            <a href="{{ route('admin.vouchers.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                Reset
                            </a>
                        </div>

                    </form>

                </div>



                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Voucher</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nilai Diskon</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Min Belanja</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mulai Berlaku</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kadaluarsa</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipe Diskon</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Maks Diskon</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>



                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($vouchers as $voucher)
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $mulai = \Carbon\Carbon::parse($voucher->mulai_berlaku);
                                    $akhir = $voucher->kadaluarsa_pada
                                        ? \Carbon\Carbon::parse($voucher->kadaluarsa_pada)
                                        : null;

                                    $isActive = $today->between($mulai, $akhir ?? $today);
                                @endphp
                                <tr>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $voucher->kode_voucher }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $voucher->nilai_diskon }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($voucher->min_belanja) }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $voucher->mulai_berlaku->translatedFormat('d F Y H:i') }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $voucher->kadaluarsa_pada->translatedFormat('d F Y H:i') ?? '-' }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $voucher->tipe_diskon }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($voucher->maks_diskon ?? '-') }}</td>

                                    <td class="px-3 py-3 whitespace-nowrap text-sm">
                                        @if ($isActive)
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 flex space-x-2">
                                        <a href="{{ route('admin.vouchers.edit', $voucher->kode_voucher) }}"
                                            class="px-3 py-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-purple-100 text-blue-800">Edit</a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher->kode_voucher) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800"
                                                onclick="return confirm('Hapus voucher ini?')">Hapus</button>
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
