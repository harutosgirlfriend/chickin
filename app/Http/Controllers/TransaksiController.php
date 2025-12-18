<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Tracking;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {

        return view('admin.regis');
    }
    public function selesai()
    {

        return view('costumer.transaksi-selesai');
    }

    public function pesanan()
    {

        $kode_transaksi = Transaksi::with(['users'])
            ->where('id_user', Auth::id())
            ->get();

        $kode = [];
        foreach ($kode_transaksi as $transaksi) {
            array_push($kode, $transaksi->kode_transaksi);
        }
        // dd($kode);
        $detailTransaksi = DetailTransaksi::with(['transaksi', 'product'])
            ->whereIn('kode_transaksi', $kode)
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
                    'harga_satuan' => $detail->harga, // Ini adalah harga satuan produk di transaksi
                    'subtotal' => $detail->subtotal,
                ];
            })->toArray();

        })->toArray();

        // dd($hasilAkhir);
        return view('costumer.pesanan', ['pesanan' => $detailTransaksi, 'transaksi' => $kode_transaksi, 'product' => $hasilAkhir]);
    }

    public function detailPesanan(Request $request)
    {
           $pesanan = Transaksi::with(['users'])
            ->where('kode_transaksi', $request->kode_transaksi)
            ->first();
        // dd($pesanan);
        $detailTransaksi = DetailTransaksi::with(['transaksi', 'product'])
            ->where('kode_transaksi', $request->kode_transaksi)
            ->get();
        $akun = Transaksi::with(['users'])
            ->where('kode_transaksi', $request->kode_transaksi)
            ->get();
        // dd($akun);
        $tracking = Tracking::with(['transaksi'])
            ->where('kode_transaksi', $request->kode_transaksi)
            ->orderBy('kode_tracking', 'desc')
            ->get();

        return view('costumer.detail-pesanan', ['pesanan' => $pesanan, 'products' => $detailTransaksi, 'tracking' => $tracking, 'status' => $pesanan['status'], 'akun' => $akun]);
    }
 public function riwayat(){
    return view('costumer.transaksi-selesai');
 }
public function updateStatus(Request $request)
{
    $request->validate([
        'kode_transaksi' => 'required',
        'status' => 'required'
    ]);

    $pesanan = Transaksi::where('kode_transaksi', $request->kode_transaksi)->firstOrFail();


    $alurStatus = [
        'Pending' => ['Disetujui', 'Ditolak'],
        'Disetujui' => ['Proses Pengantaran'],
        'Proses Pengantaran' => ['Diterima'],
        'Diterima' => [],
        'Ditolak' => []
    ];

    // cek validasi alur
    if (!in_array($request->status, $alurStatus[$pesanan->status])) {
        return back()->with('error', 'Perubahan status tidak valid');
    }

    $pesanan->status = $request->status;
    $pesanan->save();

    return back()->with('success', 'Status pesanan berhasil diperbarui');
}


}
