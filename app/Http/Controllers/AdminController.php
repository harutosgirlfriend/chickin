<?php

namespace App\Http\Controllers;

use App\Exports\PenghasilanExport;
use App\Exports\PesananExport;
use App\Exports\ProductStockExport;
use App\Exports\UsersExport;
use App\Models\DetailTransaksi;
use App\Models\Product;
use App\Models\Tracking;
use App\Models\Transaksi;
use App\Models\Users;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $produkKurangStok = Product::whereColumn('stok', '<=', 'minimal_stok')->get();
        $totalPendapatan = DB::table('transaksi')
            ->where('status', '=', 'Diterima')
            ->sum('total_bayar');

        $totalPenjualan = DB::table('transaksi')->count();

        $pesananHariIni = DB::table('transaksi')
            ->whereDate('tanggal', Carbon::today())
            ->count();

        $listPesananHariIni = DB::table('transaksi')
            ->whereDate('tanggal', Carbon::today())
            ->select(
                'kode_transaksi',
                'total_bayar',
                'status'
            )
            ->orderBy('kode_transaksi', 'desc')
            ->get();

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

        $penjualanBulanan = DB::table('transaksi')
            ->select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status', '=', 'Diterima')
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        // grafik penjualan bulanan
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
            'totalBulanan',
             'produkKurangStok'
        ));

    }

    public function registrasi()
    {
        return view('admin.registrasiAkun');
    }

    public function pesanan(Request $request)
    {
        $query = Transaksi::with(['users']);

        if ($request->filter === 'range'
            && $request->filled('tanggal_awal')
            && $request->filled('tanggal_akhir')) {

            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filter === 'bulanan' && $request->filled('bulan')) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year);
        }

        if ($request->filter === 'tahunan' && $request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pesanan = $query->orderBy('tanggal', 'desc')->get();

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
            'product' => $hasilAkhir,
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
            'status' => 'required|in:active,non active',
        ]);

        Users::where('id', $request->id_user)
            ->update(['status' => $request->status]);

        return back()->with('success', 'Status user berhasil diupdate');
    }

    public function exportExcel(Request $request)
    {
        DB::statement('SET SESSION group_concat_max_len = 10000');

        $query = DB::table('transaksi')
            ->leftJoin('detail_transaksi', 'transaksi.kode_transaksi', '=', 'detail_transaksi.kode_transaksi')
            ->leftJoin('product', 'detail_transaksi.kode_product', '=', 'product.kode_product')
            ->select(
                'transaksi.kode_transaksi',
                'transaksi.tanggal',

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

        if (
            $request->filter === 'range' &&
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {
            $query->whereBetween('transaksi.tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filter === 'bulanan' && $request->filled('bulan')) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('transaksi.tanggal', $bulan->month)
                ->whereYear('transaksi.tanggal', $bulan->year);
        }

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

    public function penghasilan(Request $request)
    {
        $query = Transaksi::with(['details.product'])
            ->withCount('details as jumlah_produk')
            ->where('status', '=', 'Diterima');

        if (
            $request->filter === 'range' &&
            $request->tanggal_awal &&
            $request->tanggal_akhir
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filter === 'bulanan' && $request->bulan) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year);
        }

        if ($request->filter === 'tahunan' && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pendapatan = (clone $query)
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalGopay = (clone $query)
            ->where('metode_pembayaran', 'gopay')
            ->sum('total_bayar');

        $totalShopeePay = (clone $query)
            ->where('metode_pembayaran', 'airpay shopee')
            ->sum('total_bayar');

        $totalTunai = (clone $query)
            ->where('metode_pembayaran', 'COD')
            ->sum('total_bayar');

        $totalBRI = (clone $query)
            ->where('metode_pembayaran', 'VA BRI')
            ->sum('total_bayar');
        $totalDana = (clone $query)
            ->where('metode_pembayaran', 'dana')
            ->sum('total_bayar');

        return view('admin.penghasilan', compact(
            'pendapatan',
            'totalGopay',
            'totalShopeePay',
            'totalDana',
            'totalTunai',
            'totalBRI'
        ));
    }

    public function exportExcelPenghasilan(Request $request)
    {
        $query = Transaksi::with(['details.product'])
            ->withCount('details as jumlah_produk')
            ->where('status', '=', 'Diterima');

        if (
            $request->filter === 'range' &&
            $request->tanggal_awal &&
            $request->tanggal_akhir
        ) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filter === 'bulanan' && $request->bulan) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year);
        }

        if ($request->filter === 'tahunan' && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pendapatan = $query->orderBy('tanggal', 'desc')->get();

        return Excel::download(
            new PenghasilanExport(
                $pendapatan,
                $request->filter ?? null,
                $request->tanggal_awal ?? null,
                $request->tanggal_akhir ?? null,
                $request->bulan ?? null,
                $request->tahun ?? null
            ),
            'penghasilan.xlsx'
        );

    }

    public function exportUserExcel()
    {
        return Excel::download(new UsersExport, 'laporan-user.xlsx');
    }

    public function exportUserPdf()
    {
        $users = Users::all();
        $pdf = Pdf::loadView('admin.lapUser', compact('users'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-user.pdf');
    }

    public function exportStockExcel()
    {
        return Excel::download(new ProductStockExport, 'laporan-stok-produk.xlsx');
    }

    public function exportStockPdf()
    {
        $products = Product::all();
        $pdf = Pdf::loadView('admin.lapStokPdf', compact('products'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-stok-produk.pdf');
    }

    public function exportPdfPenghasilan(Request $request)
    {
        $query = Transaksi::with(['details.product'])
            ->withCount('details as jumlah_produk')
            ->where('status', 'Diterima');

        if ($request->filter === 'range' && $request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filter === 'bulanan' && $request->bulan) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year);
        }

        if ($request->filter === 'tahunan' && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pendapatan = $query->orderBy('tanggal', 'desc')->get();

        $pdf = PDF::loadView('admin.lapPenghasilanPdf', [
            'pendapatan' => $pendapatan,
            'filter' => $request->filter,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);

        return $pdf->download('laporan_penghasilan.pdf');
    }

    public function exportPdfPesanan(Request $request)
    {
        DB::statement('SET SESSION group_concat_max_len = 10000');

        $query = DB::table('transaksi')
            ->leftJoin('detail_transaksi', 'transaksi.kode_transaksi', '=', 'detail_transaksi.kode_transaksi')
            ->leftJoin('product', 'detail_transaksi.kode_product', '=', 'product.kode_product')
            ->select(
                'transaksi.kode_transaksi',
                'transaksi.tanggal',
                'transaksi.total_harga',
                'transaksi.ongkir',
                'transaksi.jumlah_potongan',
                'transaksi.total_bayar',
                'transaksi.metode_pembayaran',
                'transaksi.status',
                DB::raw("GROUP_CONCAT(CONCAT(product.nama_product, ' (', detail_transaksi.jumlah, ')') SEPARATOR ', ') as produk")
            );

        if ($request->filter === 'range' && $request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('transaksi.tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filter === 'bulanan' && $request->bulan) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereMonth('transaksi.tanggal', $bulan->month)
                ->whereYear('transaksi.tanggal', $bulan->year);
        }

        if ($request->filter === 'tahunan' && $request->tahun) {
            $query->whereYear('transaksi.tanggal', $request->tahun);
        }

        $pesanan = $query->groupBy(
            'transaksi.kode_transaksi',
            'transaksi.tanggal',
            'transaksi.total_harga',
            'transaksi.ongkir',
            'transaksi.jumlah_potongan',
            'transaksi.total_bayar',
            'transaksi.metode_pembayaran',
            'transaksi.status'
        )->orderBy('transaksi.tanggal', 'desc')->get();

        // Untuk list produk per transaksi
        $product = [];
        foreach ($pesanan as $row) {
            $listProduk = [];
            foreach (explode(', ', $row->produk) as $p) {
                $matches = [];
                if (preg_match('/^(.*) \((\d+)\)$/', $p, $matches)) {
                    $listProduk[] = (object) [
                        'nama_product' => $matches[1],
                        'jumlah' => $matches[2],
                    ];
                }
            }
            $product[$row->kode_transaksi] = $listProduk;
        }

        $pdf = PDF::loadView('admin.lapPesananPdf', [
            'pesanan' => $pesanan,
            'product' => $product,
            'filter' => $request->filter,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);

        return $pdf->download('laporan_pesanan.pdf');
    }
}
