<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeritaPromoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\Feedbacks;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;
use App\Livewire\Chat;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role.redirect'])->group(function () {
    Route::get('/cekrole', function () {
        return view('admin.template');
    })->name('cekrole');
});
Route::middleware(['ceklogin'])->group(function () {
    Route::match(['get', 'post'], '/simpan/keranjang/', [ProductController::class, 'keranjang'])->name('simpan.keranjang');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

Route::middleware(['keranjang', 'checkout'])->group(function () {
    Route::match(['get', 'post'], '/checkout/auth', [CartController::class, 'checkoutAuth'])->name('checkout.auth');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/simpan/transaksi', [CartController::class, 'transaksi'])->name('simpan.transaksi');


});
Route::middleware(['auth', 'cekadmin'])->group(function () {
    Route::get('/data/product', [ProductController::class, 'dataProduct'])->name('data.product');
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::get('/admin/datapesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
    Route::get('/admin/datapesanan/detail/{kode_transaksi}', [AdminController::class, 'detailPesanan'])->name('admin.pesanan.detail');
    Route::get('/admin/management/user', [AdminController::class, 'managementUser'])->name('admin.menegement.user');
  Route::patch('/admin/users/status', [AdminController::class, 'updateStatus'])
    ->name('admin.menegement.userupdateStatus');
Route::get('/admin/pesanan/export-excel', 
    [AdminController::class, 'exportExcel']
)->name('admin.pesanan.exportExcel');
Route::delete('/product/gambar/{id}', [ProductController::class, 'deleteGambar'])
    ->name('product.gambar.delete');

Route::put('/product/gambar/main/{id}', [ProductController::class, 'setMainGambar'])
    ->name('product.gambar.main');

});

Route::middleware(['keranjang'])->group(function () {
    Route::get('/', [CostumerController::class, 'index'])->name('dashboard');
    Route::get('/detail/{kode_product}', [ProductController::class, 'detail'])->name('detail');
    Route::get('/product', [ProductController::class, 'index'])->name('product');

    Route::get('/chat', [CostumerController::class, 'chat'])->name('chat');
    Route::get('/admin/chat', [AdminController::class, 'chat'])->name('admin.chat');
    Route::post('/cek/transaksi', [CartController::class, 'cekTransaksi'])->name('cek.transaksi');
    Route::post('/generate-snap-token', [CartController::class, 'generateSnapToken'])->name('generate.snap');
    
    Route::get('/product/kategori/{kategori}', [ProductController::class, 'kategori'])->name('product.kategori');

    Route::get('/beritapromo', [BeritaPromoController::class, 'index'])->name('beritapromo');
    Route::get('/regis', [HomeController::class, 'index'])->name('regis');
    Route::get('/regis/save', [HomeController::class, 'regis'])->name('regis.save');
    Route::get('/login/view', [HomeController::class, 'loginView'])->name('login.view');
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    Route::get('/pesanan', [TransaksiController::class, 'pesanan'])->name('pesanan');
    Route::get('/pesanan/detail/{kode_transaksi}', [TransaksiController::class, 'detailPesanan'])->name('detail.pesanan');
    Route::get('/edit/product/{kode_product}', [ProductController::class, 'editProduct'])->name('edit.product');
    Route::post('/keranjang/update', [CartController::class, 'updateJumlahKeranjang'])->middleware('auth');
    Route::match(['get', 'post'], '/simpan/product', [ProductController::class, 'simpan'])->name('product.simpan');
    Route::match(['get', 'post'], '/edit/product/{kode_product}', [ProductController::class, 'update'])->name('edit.product');

// Transaksi
 Route::get('/transaksi/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');

 //profile
 Route::get('/costumer/profile', [CostumerController::class, 'profile'])->name('costumer.profile');
 Route::post('/costumer/profile/update', [CostumerController::class, 'update'])->name('costumer.update');
 Route::get('/costumer/profile/changePassword', [CostumerController::class, 'changePassword'])->name('costumer.profile.changePassword');
 Route::post('/costumer/profile/ubahPassword', [CostumerController::class, 'ubahPassword'])->name('costumer.profile.ubahPassword');
Route::post(
    '/costumer/profile/update-photo',
    [CostumerController::class, 'updatePhoto']
)->name('costumer.profile.updatePhoto');
Route::delete('/costumer/profile/photo', [CostumerController::class, 'deletePhoto'])
    ->name('costumer.profile.deletePhoto');


 Route::post('/cari/qr', [CartController::class, 'qris'])->name('qris');


 //komentar
Route::get(
    '/order/{order}/rate',
    [Feedbacks::class, 'create']
)->middleware('auth')->name('order.rate');

Route::post(
    '/order/{order}/product/{product}/rate',
    [Feedbacks::class, 'store']
)->middleware('auth')->name('product.rate');


});
Route::get('/regis/akun', [AdminController::class, 'registrasi'])->name('regisAkun');
Route::get('/transaksi/{orderId}/status', [CartController::class, 'checkStatus']);
// Route::get('/transaksi/TRX251205055617F/status', [PaymentController::class, 'checkStatus']);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'cekadmin'])->group(function() {
    Route::resource('vouchers', VouchersController::class);
});

 Route::post('/admin/pesanan/update-status', [TransaksiController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
