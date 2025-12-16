<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'kode_product';

    public $timestamps = false;

    protected $fillable = [
        'kode_product',
        'nama_product',
        'gambar',
        'stok',
        'deskripsi',
        'kategori',
        'harga',

    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'kode_product', 'kode_product');
    }
    public function productgambar()
    {
        return $this->hasMany(ProductGambar::class, 'kode_product', 'kode_product');
    }
}
