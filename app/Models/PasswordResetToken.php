<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPasswordResetToken
 */
class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',

    ];
}
