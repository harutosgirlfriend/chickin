<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {

        return view('admin.regis');
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
        $detailTransaksi = DetailTransaksi::with(['transaksi', 'product'])
            ->where('kode_transaksi', $request->kode_transaksi)
            ->get();

        // dd( $detailTransaksi);
        return view('costumer.detail-pesanan', ['pesanan' => $detailTransaksi, 'kode_transaksi' => $request->kode_transaksi]);
    }
 public function riwayat(){
    return view('costumer.transaksi-selesai');
 }
}
