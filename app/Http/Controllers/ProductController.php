<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\LogAktivitas;
use App\Models\Product;
use App\Models\ProductGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $terlaris = DB::table('detail_transaksi')
            ->join('product', 'detail_transaksi.kode_product', '=', 'product.kode_product')
            ->select(
                'product.nama_product',
                DB::raw('SUM(detail_transaksi.jumlah) as total_terjual')
            )
            ->groupBy('product.nama_product')
            ->orderByDesc('total_terjual')
            ->limit(4)
            ->get();

        $products = Product::with('productgambar')->get();

        return view('admin.dataproduct', compact('products', 'terlaris'));
    }

    public function updateStok(Request $request)
    {
        $request->validate([
            'kode_product' => 'required',
            'jumlah' => 'required|integer|min:1',
            'aksi' => 'required|in:tambah,kurangi',
        ]);

        $product = Product::where('kode_product', $request->kode_product)->firstOrFail();
        $stokSebelum = $product->stok;
        if ($request->aksi == 'tambah') {
            $product->stok += $request->jumlah;
            $aksi = 'Tambah Stok';
        } else {
            if ($product->stok < $request->jumlah) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            $product->stok -= $request->jumlah;
            $aksi = 'Kurangi Stok';
        }

        $product->save();
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'kode_product' => $product->kode_product,
            'aksi' => $aksi,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $product->stok
       
        ]);

        return back()->with('success', 'Stok berhasil diperbarui');
    }

    public function simpan(Request $request)
    {
        //  dd($request);

        $namaGambar = null;
        $kategori = $request->kategori;

        $kode_product = $this->kode_product($kategori);
        $product = Product::create([
            'kode_product' => $kode_product,
            'nama_product' => $request->nama_product,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'minimal_stok' => $request->minimal_stok,
            'harga_awal' => $request->harga_awal,
            'kategori' => $kategori,
            'gambar' => $namaGambar,
            'deskripsi' => $request->deskripsi ?? null,

        ]);
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'kode_product' => $kode_product,
            'aksi' => 'Tambah Produk',
            'stok_sebelum' => null,
            'stok_sesudah' => $product->stok,

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
            'minimal_stok' => 'required|numeric',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::where('kode_product', $request->kode_product)->firstOrFail();
        $stokSebelum = $product->stok;
        $product->update([
            'nama_product' => $request->nama_product,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ]);
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'kode_product' => $product->kode_product,
            'aksi' => 'Update Produk',
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $product->stok,
          
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

private function kode_product($kategori)
{
    $prefix = match ($kategori) {
        'ayam potong' => 'AP',
        'ayam hidup'  => 'AH',
        default       => 'TR',
    };

    $product = Product::where('kode_product', 'like', $prefix.'%')
        ->orderBy('kode_product', 'desc')
        ->first();

    if ($product) {
        $lastNumber = (int) substr($product->kode_product, -3);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }

    return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
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

    public function LogAktivitas()
    {
        $logs = LogAktivitas::with(['product', 'users'])
            ->orderByDesc('created_at')
            ->get();

        // dd($logs);
        return view('admin.logAktivitas', compact('logs'));
    }
}
