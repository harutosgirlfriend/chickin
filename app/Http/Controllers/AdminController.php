<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Tracking;
use App\Models\Transaksi;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\PesananExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
             $totalPendapatan = DB::table('transaksi')
            ->where('status', 'Diterima')
            ->sum('total_bayar');

        // =====================
        // TOTAL PENJUALAN
        // =====================
        $totalPenjualan = DB::table('transaksi')->count();

        // =====================
        // PESANAN HARI INI (JUMLAH)
        // =====================
        $pesananHariIni = DB::table('transaksi')
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // =====================
        // TABEL PESANAN HARI INI
        // =====================
        $listPesananHariIni = DB::table('transaksi')
            ->whereDate('tanggal', Carbon::today())
            ->select(
                'kode_transaksi',
                'total_bayar',
                'status'
            )
            ->orderBy('kode_transaksi', 'desc')
            ->get();

        // =====================
        // PRODUK TERLARIS (TOP 4)
        // =====================
        $produkTerlaris = DB::table('detail_transaksi')
            ->join('product', 'detail_transaksi.kode_product', '=', 'product.kode_product')
            ->select(
                'product.nama_product',
                DB::raw('SUM(detail_transaksi.jumlah) as total_terjual')
            )
            ->groupBy('product.nama_product')
            ->orderByDesc('total_terjual')
            ->limit(4)
            ->get();

        // =====================
        // GRAFIK PENJUALAN PER BULAN (TAHUN INI)
        // =====================
        $penjualanBulanan = DB::table('transaksi')
            ->select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status', 'Diterima')
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        // Format untuk Chart.js
        $bulan = [];
        $totalBulanan = [];

        foreach ($penjualanBulanan as $row) {
            $bulan[] = Carbon::create()->month($row->bulan)->translatedFormat('F');
            $totalBulanan[] = $row->total;
        }

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalPenjualan',
            'pesananHariIni',
            'listPesananHariIni',
            'produkTerlaris',
            'bulan',
            'totalBulanan'
        ));

    }

    public function registrasi()
    {
        return view('admin.registrasiAkun');
    }

public function pesanan(Request $request)
{
    $query = Transaksi::with(['users']);

    // =====================
    // RENTANG TANGGAL
    // =====================
    if ($request->filter === 'range'
        && $request->filled('tanggal_awal')
        && $request->filled('tanggal_akhir')) {

        $query->whereBetween('tanggal', [
            $request->tanggal_awal,
            $request->tanggal_akhir
        ]);
    }

    // =====================
    // BULANAN
    // =====================
    if ($request->filter === 'bulanan' && $request->filled('bulan')) {
        $bulan = Carbon::parse($request->bulan);
        $query->whereMonth('tanggal', $bulan->month)
              ->whereYear('tanggal', $bulan->year);
    }

    // =====================
    // TAHUNAN
    // =====================
    if ($request->filter === 'tahunan' && $request->filled('tahun')) {
        $query->whereYear('tanggal', $request->tahun);
    }

    $pesanan = $query->orderBy('tanggal', 'desc')->get();

    // DETAIL TRANSAKSI (IKUT FILTER)
    $detailTransaksi = DetailTransaksi::with(['transaksi', 'product'])
        ->whereIn('kode_transaksi', $pesanan->pluck('kode_transaksi'))
        ->get();

    $produkDikelompokkan = $detailTransaksi->groupBy('kode_transaksi');

    $hasilAkhir = $produkDikelompokkan->map(function ($details) {
        return $details->map(function ($detail) {
            return [
                'id_detail' => $detail->id_detail,
                'kode_product' => $detail->kode_product,
                'gambar' => $detail->product->gambar,
                'nama_product' => $detail->product->nama_product ?? 'Nama Produk Tidak Ditemukan',
                'jumlah' => $detail->jumlah,
                'harga_satuan' => $detail->harga,
                'subtotal' => $detail->subtotal,
            ];
        })->toArray();
    })->toArray();

    return view('admin.dataPesanan', [
        'pesanan' => $pesanan,
        'product' => $hasilAkhir
    ]);
}


    public function detailPesanan($kode_transaksi)
    {
        $pesanan = Transaksi::with(['users'])
            ->where('kode_transaksi', $kode_transaksi)
            ->first();
        // dd($pesanan);
        $detailTransaksi = DetailTransaksi::with(['transaksi', 'product'])
            ->where('kode_transaksi', $kode_transaksi)
            ->get();
        $akun = Transaksi::with(['users'])
            ->where('kode_transaksi', $kode_transaksi)
            ->get();
        // dd($akun);
        $tracking = Tracking::with(['transaksi'])
            ->where('kode_transaksi', $kode_transaksi)
            ->orderBy('kode_tracking', 'desc')
            ->get();

        return view('admin.detailPesanan', ['pesanan' => $pesanan, 'products' => $detailTransaksi, 'tracking' => $tracking, 'status' => $pesanan['status'], 'akun' => $akun]);
    }
    public function chat()
    {
        return view('admin.chat');
    }
    public function managementUser()
    {
        $users = Users::where('role', 'customer')
            ->get();

        return view('admin.managementUser', ['users' => $users]);

    }
    public function updateStatus(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id',
        'status' => 'required|in:active,non active'
    ]);

    Users::where('id', $request->id_user)
        ->update(['status' => $request->status]);

    return back()->with('success', 'Status user berhasil diupdate');
}
public function exportExcel(Request $request)
{
    DB::statement("SET SESSION group_concat_max_len = 10000");

    $query = DB::table('transaksi')
        ->leftJoin('detail_transaksi', 'transaksi.kode_transaksi', '=', 'detail_transaksi.kode_transaksi')
        ->leftJoin('product', 'detail_transaksi.kode_product', '=', 'product.kode_product')
        ->select(
            'transaksi.kode_transaksi',
            'transaksi.tanggal',

            // GABUNG PRODUK
            DB::raw("
                GROUP_CONCAT(
                    CONCAT(
                        product.nama_product,
                        ' (', detail_transaksi.jumlah, ')'
                    )
                    SEPARATOR ', '
                ) as produk
            "),

            'transaksi.total_harga',
            'transaksi.ongkir',
            'transaksi.jumlah_potongan',
            'transaksi.total_bayar',
            'transaksi.metode_pembayaran',
            'transaksi.status'
        );

    // =====================
    // FILTER RANGE TANGGAL
    // =====================
    if (
        $request->filter === 'range' &&
        $request->filled('tanggal_awal') &&
        $request->filled('tanggal_akhir')
    ) {
        $query->whereBetween('transaksi.tanggal', [
            $request->tanggal_awal,
            $request->tanggal_akhir
        ]);
    }

    // =====================
    // FILTER BULANAN
    // =====================
    if ($request->filter === 'bulanan' && $request->filled('bulan')) {
        $bulan = Carbon::parse($request->bulan);
        $query->whereMonth('transaksi.tanggal', $bulan->month)
              ->whereYear('transaksi.tanggal', $bulan->year);
    }

    // =====================
    // FILTER TAHUNAN
    // =====================
    if ($request->filter === 'tahunan' && $request->filled('tahun')) {
        $query->whereYear('transaksi.tanggal', $request->tahun);
    }

    $data = $query
        ->groupBy(
            'transaksi.kode_transaksi',
            'transaksi.tanggal',
            'transaksi.total_harga',
            'transaksi.ongkir',
            'transaksi.jumlah_potongan',
            'transaksi.total_bayar',
            'transaksi.metode_pembayaran',
            'transaksi.status'
        )
        ->orderBy('transaksi.tanggal', 'desc')
        ->get();

    return Excel::download(
        new PesananExport($data),
        'laporan-penjualan.xlsx'
    );
}


}
