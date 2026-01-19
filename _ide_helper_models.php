<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $gambar
 * @property string $isi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BeritaPromo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BeritaPromo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BeritaPromo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BeritaPromo whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BeritaPromo whereIsi($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBeritaPromo {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_penerima
 * @property int $id_pengirim
 * @property string|null $pesan
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $dibaca
 * @property string|null $gambar
 * @property-read \App\Models\Users $penerima
 * @property-read \App\Models\Users $pengirim
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereDibaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereIdPenerima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereIdPengirim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel wherePesan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperChatModel {}
}

namespace App\Models{
/**
 * @property int $id_detail
 * @property int $jumlah
 * @property int $subtotal
 * @property string $kode_transaksi
 * @property string $kode_product
 * @property int $harga
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Transaksi $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi whereIdDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi whereKodeProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi whereKodeTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailTransaksi whereSubtotal($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDetailTransaksi {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $id_user
 * @property string $kode_product
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $kode_transaksi
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Users $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereKodeProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereKodeTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fedbacks whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFedbacks {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode_product
 * @property int $jumlah
 * @property int $id_user
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Users $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keranjang whereKodeProduct($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperKeranjang {}
}

namespace App\Models{
/**
 * @property string $email
 * @property string $token
 * @property string|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordResetToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordResetToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordResetToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordResetToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordResetToken whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordResetToken whereToken($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPasswordResetToken {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $payment_type
 * @property string $status
 * @property string $kode_transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereKodeTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStatus($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPayment {}
}

namespace App\Models{
/**
 * @property string $kode_product
 * @property string $nama_product
 * @property string|null $gambar
 * @property int $stok
 * @property string $deskripsi
 * @property string $kategori
 * @property int $harga
 * @property int $harga_awal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Fedbacks> $feedback
 * @property-read int|null $feedback_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Keranjang> $keranjang
 * @property-read int|null $keranjang_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductGambar> $productgambar
 * @property-read int|null $productgambar_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHargaAwal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereKodeProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNamaProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStok($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProduct {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode_product
 * @property string $gambar
 * @property string $main_gambar
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar whereKodeProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductGambar whereMainGambar($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProductGambar {}
}

namespace App\Models{
/**
 * @property int $kode_tracking
 * @property string $kode_transaksi
 * @property string $status
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Transaksi $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking whereKodeTracking($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking whereKodeTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tracking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTracking {}
}

namespace App\Models{
/**
 * @property string $kode_transaksi
 * @property numeric $total_harga
 * @property string|null $metode_pembayaran
 * @property string $kota
 * @property string $alamat
 * @property int $id_user
 * @property \Illuminate\Support\Carbon $tanggal
 * @property numeric $ongkir
 * @property string $status
 * @property numeric $total_bayar
 * @property int|null $kode_voucher
 * @property numeric|null $jumlah_potongan
 * @property string $kecamatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetailTransaksi> $details
 * @property-read int|null $details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tracking> $tracking
 * @property-read int|null $tracking_count
 * @property-read \App\Models\Users $users
 * @property-read \App\Models\Vouchers|null $vouchers
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereJumlahPotongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKodeTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKodeVoucher($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereMetodePembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereOngkir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTotalBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTotalHarga($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTransaksi {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $password
 * @property string $no_hp
 * @property string $role
 * @property string $email
 * @property string|null $gambar
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string $status
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $password
 * @property string $no_hp
 * @property string $role
 * @property string $email
 * @property string|null $gambar
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatModel> $chat
 * @property-read int|null $chat_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Fedbacks> $feedback
 * @property-read int|null $feedback_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Keranjang> $keranjang
 * @property-read int|null $keranjang_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaksi> $transaksi
 * @property-read int|null $transaksi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUsers {}
}

namespace App\Models{
/**
 * @property int $kode_voucher
 * @property int $nilai_diskon
 * @property numeric $min_belanja
 * @property \Illuminate\Support\Carbon $mulai_berlaku
 * @property \Illuminate\Support\Carbon|null $kadaluarsa_pada
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $tipe_diskon
 * @property numeric|null $maks_diskon
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaksi> $transaksi
 * @property-read int|null $transaksi_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers valid(float $subtotal)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereKadaluarsaPada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereKodeVoucher($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereMaksDiskon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereMinBelanja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereMulaiBerlaku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereNilaiDiskon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereTipeDiskon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vouchers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperVouchers {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|qris newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|qris newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|qris query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperqris {}
}

