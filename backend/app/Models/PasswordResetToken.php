<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $primaryKey = 'email'; // Laravel usará `email` en lugar de `id`
    public $incrementing = false; // Indicar que `email` no es autoincremental
    protected $keyType = 'string'; // Si el email es string

    protected $fillable = [
        'email',
        'token'
    ];
    const UPDATED_AT = null;
}
