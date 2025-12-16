<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Tracking;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function registrasi()
    {
        return view('admin.registrasiAkun');
    }

    public function pesanan()
    {
        $pesanan = Transaksi::with(['users'])
            ->get();

        $detailTransaksi = DetailTransaksi::with(['transaksi', 'product'])
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

        // dd($hasilAkhir);
        return view('admin.dataPesanan', ['pesanan' => $pesanan, 'product' => $hasilAkhir]);
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
}
