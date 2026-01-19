@extends('templateAdmin')

@section('content')
    <div class="col-span-1 xl:col-span-1 md:col-span-6">
        <div class="card">
            <div class="p-4 sm:p-6 bg-white shadow-lg rounded-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm text-gray-500">Total Saldo GoPay</p>
                        <h3 class="text-2xl font-bold text-green-600">
                            Rp {{ number_format($totalGopay) }}
                        </h3>
                    </div>


                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm text-gray-500">Total Saldo ShopeePay</p>
                        <h3 class="text-2xl font-bold text-orange-500">
                            Rp {{ number_format($totalShopeePay) }}
                        </h3>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm text-gray-500">Total Tunai</p>
                        <h3 class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($totalTunai) }}
                        </h3>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm text-gray-500">Total Dana</p>
                        <h3 class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($totalDana) }}
                        </h3>
                    </div>



                </div>

                <div class="flex justify-between items-center mb-6 mt-5">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        Data Penghasilan
                    </h2>
                    <form method="GET" class="flex flex-wrap gap-3 mb-6">


                        <select name="filter" id="filterMode" class="border rounded px-3 py-2 text-sm"
                            onchange="toggleFilter()">

                            <option value="">Pilih Filter</option>
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


                        <div id="range" class="flex gap-2">
                            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                                class="border rounded px-3 py-2 text-sm">

                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                class="border rounded px-3 py-2 text-sm">
                        </div>


                        <div id="bulanan">
                            <input type="month" name="bulan" value="{{ request('bulan') }}"
                                class="border rounded px-3 py-2 text-sm">
                        </div>


                        <div id="tahunan">
                            <input type="number" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun"
                                class="border rounded px-3 py-2 text-sm w-28">
                        </div>

                        <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
                            Terapkan
                        </button>

                        <a href="{{ route('admin.penghasilan') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">
                            Reset
                        </a>
                        <button type="submit" formaction="{{ route('admin.penghasilan.exportExcel') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded">
                            Cetak Excel
                        </button>
                        <button type="submit" formaction="{{ route('admin.penghasilan.exportPdf') }}"
                            class="bg-red-600 text-white px-4 py-2 rounded">
                            Cetak PDF
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
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Produk
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga awal
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode
                                    Pembayaran</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Potongan
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ongkir</th>
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Laba Bersih
                                </th>

                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pendapatan as $penghasilan)
                                @php
                                    $totalHargaAwal = 0;
                                @endphp

                                @foreach ($penghasilan->details as $detail)
                                    @php
                                        $totalHargaAwal += ($detail->product->harga_awal ?? 0) * ($detail->jumlah ?? 1);
                                    @endphp
                                @endforeach

                                <tr>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $penghasilan->kode_transaksi }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $penghasilan->tanggal->translatedFormat('d F Y') }}

                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $penghasilan->jumlah_produk }} Produk
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ number_format($penghasilan->total_harga) }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ number_format($totalHargaAwal) }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ $penghasilan->metode_pembayaran }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ number_format($penghasilan->jumlah_potongan) }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ number_format($penghasilan->ongkir) }}
                                    </td>

                                    <td class="px-3 py-3 text-sm text-gray-900">
                                        {{ number_format($penghasilan->total_harga - $totalHargaAwal - $penghasilan->jumlah_potongan) }}
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


        toggleFilter();
    </script>
@endsection
