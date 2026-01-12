<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use App\Models\ProductGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\alert;

class ProductController extends Controller
{
    private $product;

    public function index()
    {
        $product = Product::with('feedback')->get();

        return view('costumer.product', ['product' => $product]);
    }

    public function detail($kode_product)
    {

        $product = Product::with(['productgambar', 'feedback.user'])->where('kode_product', $kode_product)->firstOrFail();

        // dd($product);
        return view('costumer.detail', ['product' => $product]);
    }

    public function kategori($kategori)
    {
        $kategori = Product::where('kategori', $kategori)->get();

        //  var_dump($kategori);
        return view('costumer.product', ['product' => $kategori]);
    }

    public function keranjang(Request $request)
    {
        $auth = Auth::user();
        $index = Keranjang::with(['product', 'user'])
            ->where('id_user', Auth::id())
            ->where('kode_product', $request->kode_product)
            ->first();
        // dd($index);
        if ($index) {
            $index->jumlah += $request->jumlah;
            $index->save();

        } else {
            $keranjang = Keranjang::create([
                'kode_product' => $request->kode_product,
                'jumlah' => $request->jumlah,
                'id_user' => $auth->id]);

            if ($keranjang->save()) {
                alert('data berhasil disimpan');
            }

        }

        return redirect()->back();

    }

    public function dataProduct()
    {
        $products = Product::with('productgambar')->get();

        return view('admin.dataproduct', compact('products'));
    }

    public function simpan(Request $request)
    {
        //  dd($request);

        $namaGambar = null;

        $kode_product = $this->kode_product();
        $product = Product::create([
            'kode_product' => $kode_product,
            'nama_product' => $request->nama_product,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'gambar' => $namaGambar,
            'deskripsi' => $request->deskripsi ?? null,

        ]);

        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $index => $file) {

                $namaGambar = $file->hashName();
                $file->move(public_path('images/product'), $namaGambar);

                ProductGambar::create([
                    'kode_product' => $kode_product,
                    'gambar' => $namaGambar,
                    'main_gambar' => $index == 0 ? 1 : 0,
                ]);

                if ($index == 0) {
                    $product->update([
                        'gambar' => $namaGambar,
                    ]);
                }
            }
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {

        $request->validate([
            'kode_product' => 'required',
            'nama_product' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::where('kode_product', $request->kode_product)->firstOrFail();

        $product->update([
            'nama_product' => $request->nama_product,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $file) {

                $namaFile = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images/product'), $namaFile);

                ProductGambar::create([
                    'kode_product' => $request->kode_product,
                    'gambar' => $namaFile,
                    'main_gambar' => 0,
                ]);
            }
        }

         return redirect()
            ->route('data.product') 
            ->with('success', 'Data product berhasil diupdate');
    }

    private function kode_product()
    {

        $product = Product::orderBy('kode_product', 'desc')->first();
        if ($product) {
            $lastIdString = $product['kode_product'];
            $lastIdNumber = (int) substr($lastIdString, -3);
            $nextIdNumber = $lastIdNumber + 1;
            $nextId = 'AY'.str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $nextId = 'AY001';
        }

        return $nextId;

    }

    public function deleteGambar($id)
    {
        $gambar = ProductGambar::findOrFail($id);

        $path = public_path('images/product/'.$gambar->gambar);
        if (File::exists($path)) {
            File::delete($path);
        }

        $kodeProduct = $gambar->kode_product; 
        $gambar->delete();

        return redirect()
            ->route('data.product') 
            ->with('success', 'Gambar berhasil dihapus');
    }

    public function setMainGambar($id)
    {
        $gambar = ProductGambar::findOrFail($id);
        $product = Product::where('kode_product', $gambar->kode_product)->first();
        $product->update(['gambar' => $gambar->gambar]);
        ProductGambar::where('kode_product', $gambar->kode_product)
            ->update(['main_gambar' => 0]);

        $gambar->update(['main_gambar' => 1]);

        return redirect()->back()->with('success', 'Gambar utama berhasil diubah');
    }
}
