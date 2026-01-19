<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Product;
use App\Models\qris;
use App\Models\Tracking;
use App\Models\Transaksi;
use App\Models\Vouchers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Transaction;
use stdClass;

class CartController extends Controller
{
    public function ambilDaftarVoucher($totalSubtotal)
    {
        return Vouchers::valid($totalSubtotal)
            ->orderByDesc('nilai_diskon')
            ->get()
            ->map(function ($voucher) use ($totalSubtotal) {
                $voucher->jumlah_diskon = $voucher->hitungDiskon($totalSubtotal);

                return $voucher;
            });
    }

    public function ambilMidtrans($params)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
 

        return \Midtrans\Snap::getSnapToken($params);
    }

    public function checkout(Request $request)
    {
        if ($request->product) {
            $ambilData = Product::where('kode_product', $request->product['kode_product'])->first();
            $product = json_decode(json_encode([

                'kode_product' => $ambilData->kode_product,
                'nama_product' => $ambilData->nama_product,
                'gambar' => $ambilData->gambar,
                'harga' => $ambilData->harga,
                'jumlah' => $request->product['jumlah'],
                'id_user' => Auth::id(),

            ]));
        } else {
            $ambilData = Product::where('kode_product', $request->kode_product)->first();
            $product = json_decode(json_encode([

                'kode_product' => $ambilData->kode_product,
                'nama_product' => $ambilData->nama_product,
                'gambar' => $ambilData->gambar,
                'harga' => $ambilData->harga,
                'jumlah' => $request->jumlah,
                'id_user' => Auth::id(),

            ]));
            // dd($product->nama_product);

        }

        $items = null;
        $voucher = $this->ambilDaftarVoucher($product->harga * $product->jumlah);
        $kodetrans = $this->kode_transaksi();

        return view('costumer.checkout',
            ['product' => $product,
                'items' => $items,
                'total' => ($product->harga * $product->jumlah),
                'voucher' => $voucher,
                'kode_transaksi' => $kodetrans]);
    }

    public function checkoutAuth(Request $request)
    {

        $total = $request->input('total');
        // dd($request);
        $selectedItems = json_decode($request->input('selected_items'), true);

        if (empty($selectedItems)) {
            return back()->with('error', 'Pilih setidaknya satu item untuk checkout.');
        }

        $items = Keranjang::with('product')
            ->whereIn('id', $selectedItems)
            ->where('id_user', Auth::id())
            ->get();
        $product = null;
        $voucher = $this->ambilDaftarVoucher($total);

        $kodetrans = $this->kode_transaksi();

        //    dd($snapToken);
        return view('costumer.checkout', [
            'items' => $items,
            'total' => $total,
            'product' => $product,
            'voucher' => $voucher,
            'kode_transaksi' => $kodetrans,
        ]);
    }

    // public function qris(Request $request)
    // {
    //     \Midtrans\Config::$serverKey = config('midtrans.server_key');
    //     \Midtrans\Config::$isProduction = false;

    //     $orderId = $request->kode_transaksi;
    //     $total = (int)$request->total_harga;
    //             if( $qris = qris::where('kode_transaksi',$orderId)->first()){
    //                 return response()->json([
    //                 'status' => 'success',
    //                 'qr_url' => $qris->qr?? null,
    //                 'qr_string' => null,

    //             ]);}
    //     $params = [
    //         'payment_type' => 'qris',
    //         'transaction_details' => [
    //             'order_id' => $orderId,
    //             'gross_amount' => $total,
    //         ],
    //     ];

    //     $charge = \Midtrans\CoreApi::charge($params);

    //     qris::create([
    //     'kode_transaksi' => $orderId,
    //     'qr' => $charge->actions[0]->url ?? null,

    // ]);
    //     return response()->json([
    //         'status' => 'success',
    //         'qr_url' => $charge->actions[0]->url ?? null,
    //         'qr_string' => $charge->qris->qr_string ?? null,
    //     ]);
    // }

    public function cekTransaksi(Request $request)
    {

        $kode = $request->kode_transaksi;
        $metode = $request->metode_pembayaran;

        if ($metode !== 'nontunai') {
            return response()->json([
                'success' => true,
                'pembayaran' => 'COD',
            ]);
        }

        try {

            $payment = $this->checkStatus($kode);
            if (! $payment) {
                return response()->json([
                    'success' => false,
                    'error' => 'Transaksi tidak ditemukan',
                ], 404);
            }

            if ($payment->status === 'belum dibayar') {
                return response()->json([
                    'success' => false,
                    'error' => 'Anda belum menyelesaikan pembayaran',
                ]);
            }

            if ($payment->status === 'belum memilih') {
                return response()->json([
                    'success' => false,
                    'error' => 'Anda belum memilih jenis pembayaran',
                ]);
            }

            if ($payment->status === 'lunas') {
                return response()->json([
                    'success' => true,
                    'pembayaran' => $payment->payment_type,
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Status pembayaran tidak dikenali',
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
        }

    }

    public function generateSnapToken(Request $request)
    {
        // $request->validate([
        //     'kode_transaksi' => 'required|string',
        //     'subtotal'       => 'required|numeric|min:1',
        //     'id_voucher'     => 'nullable|exists:vouchers,kode_voucher',
        // ]);

        $item_details = [];

        if ($request->filled('items')) {
            foreach ($request->items as $item) {
                $item_details[] = [
                    'id' => $item['kode_product'],
                    'price' => (int) $item['harga'],
                    'quantity' => (int) $item['jumlah'],
                    'name' => $item['nama_product'],
                ];
            }
        } else {
            $item_details[] = [
                'id' => $request->kode_product,
                'price' => (int) $request->harga,
                'quantity' => (int) $request->jumlah,
                'name' => $request->nama_product,
            ];
        }

        $subtotal = (float) $request->subtotal;
        $ongkir = $request->ongkir ?? 0;
        $diskon = 0;

        if ($request->id_voucher) {
            $voucher = Vouchers::where('kode_voucher', $request->id_voucher)->first();

            if ($voucher && $subtotal >= $voucher->min_belanja) {
                if ($voucher->tipe_diskon === 'persen') {
                    $diskon = $subtotal * ($voucher->nilai_diskon / 100);
                    if ($voucher->maks_diskon) {
                        $diskon = min($diskon, $voucher->maks_diskon);
                    }
                } else {
                    $diskon = $voucher->nilai_diskon;
                }
            }
        }

   
        $item_details[] = [
            'id' => 'SHIPPING',
            'price' => $ongkir,
            'quantity' => 1,
            'name' => 'Ongkos Kirim',
        ];

     
        if ($diskon > 0) {
            $item_details[] = [
                'id' => 'DISCOUNT',
                'price' => -(int) round($diskon),
                'quantity' => 1,
                'name' => 'Diskon Voucher',
            ];
        }


        $grossAmount = collect($item_details)->sum(fn ($i) => $i['price'] * $i['quantity']);

        $params = [
            'transaction_details' => [
                'order_id' => $request->kode_transaksi,
                'gross_amount' => (int) round($grossAmount),
            ],
            'item_details' => $item_details,
        ];

        $snapToken = $this->ambilMidtrans($params);

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'total' => $grossAmount,
            'diskon' => $diskon,
        ]);
    }

    public function transaksi(Request $request)
    {
        if (! $request->kota) {
            return redirect()->back()
                ->with('error', 'Kabupaten/Kota wajib dipilih.')
                ->withInput();
        }
        if (! $request->metode_pembayaran) {
            return redirect()->back()
                ->with('error', 'Metode pembayaran wajib dipilih.')
                ->withInput();
        }

        if (! $request->kecamatan) {
            return redirect()->back()
                ->with('error', 'Kecamatan wajib dipilih.')
                ->withInput();
        }
        $totalHarga = 0;
        $pembayaran = $request->metode_pembayaran;

        if ($pembayaran == 'nontunai') {
            $payment = $this->checkStatus($request->kode_transaksi);

            if ($payment->status === 'lunas') {
                $pembayaran = $payment->payment_channel;  
            }
        }
        if ($request->items) {
            foreach ($request->items as $item) {
                $totalHarga += $item['subtotal'];
            }

        } else {
            $totalHarga = $request->total_harga;
        }
        $jumlahDiskon = 0;
        $voucherKode = $request->voucher;

        if ($voucherKode) {
            $voucher = Vouchers::where('kode_voucher', $voucherKode)->first();

            if ($voucher && $voucher->min_belanja <= $totalHarga) {
                $jumlahDiskon = $voucher->hitungDiskon($totalHarga);
            }
        }

        $ongkir = $request->ongkir ?? 0;

        $totalBayar = $totalHarga - $jumlahDiskon + $ongkir;

        Transaksi::create([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_voucher' => $request->voucher,
            'total_harga' => $totalHarga,
            'jumlah_potongan' => $jumlahDiskon,
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => $pembayaran,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'alamat' => $request->alamat,
            'id_user' => $request->id_user,
            'tanggal' => now()->toDateString(),
            'ongkir' => $ongkir,
            'status' => 'Pending',
        ]);
        Tracking::create([
            'kode_transaksi' => $request->kode_transaksi,
            'status' => 'Pending',
  
        ]);
        // dd($request->items);
        if ($request->items) {
            foreach ($request->items as $item) {
                DetailTransaksi::create([
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                    'kode_transaksi' => $request->kode_transaksi,
                    'kode_product' => $item['kode_product'],
                    'harga' => $item['harga'],
                ]);
                Keranjang::where('kode_product', $item['kode_product'])
                    ->where('id_user', Auth::id())
                    ->delete();

            }
        } else {
            DetailTransaksi::create([
                'jumlah' => $request->jumlah,
                'subtotal' => $request->subtotal,
                'kode_transaksi' => $request->kode_transaksi,
                'kode_product' => $request->kode_product,
                'harga' => $request->harga,
            ]);

        }

        return redirect()->route('transaksi.selesai');

    }

    private function kode_transaksi()
    {

        $dateTime = Carbon::now();

        $datePart = $dateTime->format('ymd');
        $timePart = $dateTime->format('His');

        $prefix = 'TRX';

        $securityChar = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 1);

        $code = $prefix.$datePart.$timePart.$securityChar;

        return $code;
    }

    public function updateJumlahKeranjang(Request $request)
    {

        $itemId = $request->input('id');
        $newJumlah = $request->input('jumlah');

        try {

            $keranjangItem = Keranjang::with('product')
                ->where('id_user', Auth::id())
                ->where('id', $itemId)
                ->firstOrFail();

            if ($newJumlah == 0) {
                $keranjangItem->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah keranjang berhasil diperbarui.',
                    'hapus' => true,
                ]);
            } else {
                $keranjangItem->jumlah = $newJumlah;
                $keranjangItem->save();

                $harga = (float) $keranjangItem->product->harga;
                $subtotal = $harga * $newJumlah;

                $semuaItemKeranjang = Keranjang::with('product')
                    ->where('id_user', Auth::id())
                    ->get();

                $grandTotal = $semuaItemKeranjang->sum(function ($item) {
                    return (float) $item->product->harga * $item->jumlah;
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah keranjang berhasil diperbarui.',
                    'new_subtotal_item' => $subtotal,
                    'new_grand_total' => $grandTotal, 
                ]);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        } catch (\Exception $e) {
        }
    }

   public function checkStatus($orderId)
{
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false;

    try {
        $status = Transaction::status($orderId);

        if (is_array($status)) {
            $status = (object) $status;
        }

    } catch (\Exception $e) {
        \Log::warning("Midtrans Error: {$e->getMessage()} | Order ID: {$orderId}");

        $payment = new stdClass;
        $payment->kode_transaksi = $orderId;
        $payment->payment_type = null;
        $payment->payment_channel = null;
        $payment->status = 'belum memilih';

        return $payment;
    }

    $payment = new stdClass;
    $payment->kode_transaksi = $orderId;
    $payment->payment_type = $status->payment_type ?? null;

    if (($status->payment_type ?? null) === 'qris') {
        $payment->payment_channel = $status->acquirer
            ?? $status->issuer
            ?? 'qris';
    } else {
        $payment->payment_channel = $status->bank
            ?? $status->payment_type
            ?? null;
    }


    if (in_array($status->transaction_status ?? '', ['settlement', 'capture'])) {
        $payment->status = 'lunas';
    } elseif (($status->transaction_status ?? '') === 'pending') {
        $payment->status = 'belum dibayar';
    } else {
        $payment->status = 'belum memilih';
    }

    return $payment;
}

}
