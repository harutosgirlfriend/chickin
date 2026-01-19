<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperqris
 */
class qris extends Model
{
    protected $table = 'qris';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'kode_transaksi',
        'qr'
     

    ];
}
