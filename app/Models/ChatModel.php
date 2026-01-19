<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperChatModel
 */
class ChatModel extends Model
{
    protected $table = 'chat';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id_pengirim',
        'id_penerima',
        'pesan',
        'created_at',
        'updated_at',
        'dibaca',
        'gambar'

    ];
    public function pengirim()
    {
        return $this->belongsTo(Users::class, 'id_pengirim', 'id');
    }
    public function penerima()
    {
        return $this->belongsTo(Users::class, 'id_penerima', 'id');
    }

}
