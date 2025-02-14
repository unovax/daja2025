<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends BaseModel
{
    protected $prefix = 'CL';
    protected $fillable = [
        'code',
        'name',
        'lastname',
        'email',
        'phone',
    ];

}
