<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFedbacks
 */
class Fedbacks extends Model
{
        protected $table = 'product_feedbacks';

    protected $primaryKey = 'id';
        protected $fillable = ['id_user', 'kode_product', 'rating', 'comment','created_at', 'updated_at','kode_transaksi'];
           public $timestamps = true;

               public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id');
    }
               public function product()
    {
        return $this->belongsTo(Product::class, 'kode_product', 'kode_product');
    }
}
