@extends('templateAdmin')

@section('content')
<div class="space-y-8">

    {{-- ================= CARD RINGKASAN ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Pendapatan</p>
            <h2 class="text-2xl font-bold text-green-600">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Penjualan</p>
            <h2 class="text-2xl font-bold text-blue-600">
                {{ $totalPenjualan }} Transaksi
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
            <h2 class="text-2xl font-bold text-purple-600">
                {{ $pesananHariIni }} Pesanan
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500 mb-3">Top 4 Produk Terlaris</p>
            <ul class="space-y-2 text-sm">
                @foreach ($produkTerlaris as $produk)
                    <li class="flex justify-between">
                        <span>{{ $produk->nama_product }}</span>
                        <span class="font-semibold">{{ $produk->total_terjual }}x</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    {{-- ================= GRAFIK PENJUALAN ================= --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold mb-4">Grafik Penjualan Per Bulan</h3>
        <canvas id="penjualanChart" height="100"></canvas>
    </div>

    {{-- ================= TABEL PESANAN HARI INI ================= --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold mb-4">Pesanan Hari Ini</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            Kode Transaksi
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            Total Bayar
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($listPesananHariIni as $pesanan)
                        <tr>
                            <td class="px-4 py-2 text-sm">
                                {{ $pesanan->kode_transaksi }}
                            </td>
                            <td class="px-4 py-2 text-sm">
                                Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($pesanan->status == 'Diterima') bg-green-100 text-green-700
                                    @elseif($pesanan->status == 'Pending') bg-blue-100 text-blue-700
                                    @elseif($pesanan->status == 'Ditolak') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ $pesanan->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                Tidak ada pesanan hari ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= CHART.JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('penjualanChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($bulan),
            datasets: [{
                label: 'Total Penjualan',
                data: @json($totalBulanan),
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
