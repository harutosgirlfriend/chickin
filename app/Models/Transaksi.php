<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTransaksi
 */
class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $primaryKey = 'kode_transaksi';

    protected $casts = [
        'kode_transaksi' => 'string',
         'tanggal' => 'date',
    ];

    public $timestamps = false;

    protected $fillable = [
        'kode_transaksi',
        'total_harga',
        'metode_pembayaran',
        'total_bayar',
        'kota',
        'kecamatan',
        'alamat',
        'id_user',
        'tanggal',
        'ongkir',
        'status',
        'kode_voucher',
        'jumlah_potongan'

    ];


    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'kode_transaksi', 'kode_transaksi');
    }

    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'kode_transaksi', 'kode_transaksi');
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id');
    }
    public function vouchers()
    {
        return $this->belongsTo(Vouchers::class, 'kode_voucher', 'kode_voucher');
    }
  

}
