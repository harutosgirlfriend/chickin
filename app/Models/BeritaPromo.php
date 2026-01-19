<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBeritaPromo
 */
class BeritaPromo extends Model
{
    protected $table = 'berita_promo';

    protected $primaryKey = 'kode_product';
}
