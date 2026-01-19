<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperKeranjang
 */
class Keranjang extends Model
{
    //
    protected $table = 'keranjang';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'kode_product',
        'jumlah',
        'id_user',

    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'kode_product', 'kode_product');
    }
}
