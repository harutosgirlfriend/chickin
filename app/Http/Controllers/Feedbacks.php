<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Fedbacks;
use App\Models\Product;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\ProductFeedback;
use Illuminate\Support\Facades\Auth;

class Feedbacks extends Controller
{
   public function create($order)
{
        $products = DetailTransaksi::with('product')
        ->where('kode_transaksi', $order)
        ->get();

// dd($pesanan);



    return view('costumer.rating', [
        'pesanan' => $products,
        'products' => $products,
     
    ]);
}

    public function store(Request $request, $order, $product)
{
    $product= Product::where('kode_product', $product)->first();


  
    $alreadyRated = Fedbacks::where('id_user', auth()->id())
        ->where('kode_transaksi', $order)
        ->where('kode_product', $product)
        ->exists();

    if ($alreadyRated) {
        return back()->with('error', 'Produk ini sudah kamu beri penilaian');
    }



        Fedbacks::create([
            'id_user' =>Auth::id(),
            'kode_transaksi' => $order,
            'kode_product' => $product->kode_product,
            'rating' => $request->rating,
            'comment' => $request->komentar,
        ]);

        return back()->with('success', 'Rating berhasil dikirim');
    }

}
