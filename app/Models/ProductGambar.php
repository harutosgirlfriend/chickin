<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductGambar
 */
class ProductGambar extends Model
{
     protected $table = 'product_gambar';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'kode_product',
        'gambar',
        'main_gambar'

    ];

    public function product()
    {

        return $this->belongsTo(Product::class, 'kode_product', 'kode_product');
    }

}
