<?php

namespace App\Models;

class Measure extends BaseModel
{
    protected $prefix = 'ME';

    protected $fillable = [
        'code',
        'name',
        'value',
        'client_id',
        'unit_id',
    ];

    public function unit(){
        return $this->belongsTo(Unit::class)->withTrashed();
    }

    public function client(){
        return $this->belongsTo(Client::class)->withTrashed();
    }
}
