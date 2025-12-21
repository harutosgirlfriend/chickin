@extends('templateAdmin')

@section('content')
    <div class="col-span-1 xl:col-span-1 md:col-span-6">
        <div class="card">
            <div class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        Data Pesanan
                    </h2>
                    <form method="GET" class="flex flex-wrap gap-3 mb-6">

                        {{-- MODE FILTER --}}
                        <select name="filter" id="filterMode" class="border rounded px-3 py-2 text-sm"
                            onchange="toggleFilter()">

                            <option value="">-- Pilih Filter --</option>
                            <option value="range" {{ request('filter') == 'range' ? 'selected' : '' }}>
                                Rentang Tanggal
                            </option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>
                                Bulanan
                            </option>
                            <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>
                                Tahunan
                            </option>
                        </select>

                        {{-- RENTANG TANGGAL --}}
                        <div id="range" class="flex gap-2">
                            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                                class="border rounded px-3 py-2 text-sm">

                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                class="border rounded px-3 py-2 text-sm">
                        </div>

                        {{-- BULANAN --}}
                        <div id="bulanan">
                            <input type="month" name="bulan" value="{{ request('bulan') }}"
                                class="border rounded px-3 py-2 text-sm">
                        </div>

                        {{-- TAHUNAN --}}
                        <div id="tahunan">
                            <input type="number" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun"
                                class="border rounded px-3 py-2 text-sm w-28">
                        </div>

                        <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
                            Terapkan
                        </button>

                        <a href="{{ route('admin.pesanan') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">
                            Reset
                        </a>
                        <button type="submit" formaction="{{ route('admin.pesanan.exportExcel') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded">
                            Cetak Excel
                        </button>
                    </form>

                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Transaksi
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Bayar</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Produk
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pesanan as $pesan)
                                @php
                                    $kode_transaksi = $pesan->kode_transaksi;
                                    $daftar_produk = $product[$kode_transaksi] ?? [];

                                    $status_class = match ($pesan->status) {
                                        'Pending' => 'bg-blue-200 text-blue-800',
                                        'Disetujui' => 'bg-indigo-200 text-indigo-800',
                                        'Proses Pengantaran' => 'bg-yellow-200 text-yellow-800',
                                        'Diterima' => 'bg-green-200 text-green-800',
                                        'Ditolak' => 'bg-red-200 text-red-800',
                                        default => 'bg-gray-200 text-gray-800',
                                    };

                                    $allowedNextStatus = [
                                        'Pending' => ['Pending', 'Disetujui', 'Ditolak'],
                                        'Disetujui' => ['Disetujui', 'Proses Pengantaran'],
                                        'Proses Pengantaran' => ['Proses Pengantaran', 'Diterima'],
                                        'Diterima' => ['Diterima'],
                                        'Ditolak' => ['Ditolak'],
                                    ];
                                @endphp

                                <tr>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $pesan->kode_transaksi }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $pesan->tanggal }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $pesan->total_harga }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $pesan->total_bayar }}
                                    </td>

                                    <td class="px-3 py-3 text-sm">
                                        <form action="{{ route('admin.pesanan.updateStatus') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="kode_transaksi"
                                                value="{{ $pesan->kode_transaksi }}">

                                            <select name="status" onchange="this.form.submit()"
                                                class="text-xs font-semibold rounded-full px-3 py-2 cursor-pointer {{ $status_class }}">

                                                @foreach ($allowedNextStatus[$pesan->status] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $pesan->status === $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ count($daftar_produk) }} Produk
                                    </td>

                                    <td class="px-3 py-3 text-sm">
                                        <a href="{{ route('admin.pesanan.detail', $pesan->kode_transaksi) }}"
                                            class="inline-flex items-center px-3 py-2 text-xs font-semibold text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        function toggleFilter() {
            let mode = document.getElementById('filterMode').value;

            document.getElementById('range').style.display =
                mode === 'range' ? 'flex' : 'none';

            document.getElementById('bulanan').style.display =
                mode === 'bulanan' ? 'block' : 'none';

            document.getElementById('tahunan').style.display =
                mode === 'tahunan' ? 'block' : 'none';
        }

        // auto run saat reload
        toggleFilter();
    </script>
@endsection
