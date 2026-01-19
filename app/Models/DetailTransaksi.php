<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDetailTransaksi
 */
class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $primaryKey = 'id_detail';

    public $timestamps = false;

    protected $fillable = [
        'jumlah',
        'subtotal',
        'kode_transaksi',
        'kode_product',
        'harga',

    ];

    public function product()
    {

        return $this->belongsTo(Product::class, 'kode_product', 'kode_product');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode_transaksi');
    }
}
