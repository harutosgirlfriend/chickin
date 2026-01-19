<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Fedbacks;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\DB;

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
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'nullable|string|max:500',
        'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'rating.required' => 'Silakan pilih rating terlebih dahulu.',
        'rating.integer' => 'Rating tidak valid.',
        'rating.min' => 'Rating minimal 1.',
        'rating.max' => 'Rating maksimal 5.',
        'foto.*.image' => 'File harus berupa gambar.',
        'foto.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
        'foto.*.max' => 'Ukuran gambar maksimal 2MB per file.',
    ]);

    $product = Product::where('kode_product', $product)->firstOrFail();

    // Cek rating sudah ada
    $alreadyRated = Fedbacks::where('id_user', auth()->id())
        ->where('kode_transaksi', $order)
        ->where('kode_product', $product->kode_product)
        ->exists();

    if ($alreadyRated) {
        return back()->with('error', 'Produk ini sudah kamu beri penilaian');
    }

    // Simpan feedback
    $feedback = Fedbacks::create([
        'id_user' => auth()->id(),
        'kode_transaksi' => $order,
        'kode_product' => $product->kode_product,
        'rating' => $request->rating,
        'comment' => $request->komentar,
    ]);

    // Simpan foto jika ada
    if ($request->hasFile('foto')) {
        $files = $request->file('foto');
        if (!is_array($files)) {
            $files = [$files]; // pastikan jadi array
        }

        foreach ($files as $file) {
            $path = $file->store('feedbacks', 'public'); // simpan di storage/app/public/feedbacks
            $feedback->photos()->create(['foto' => $path]);
        }
    }

    return back()->with('success', 'Rating berhasil dikirim');
}


}
