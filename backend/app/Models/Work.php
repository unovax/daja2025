<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends BaseModel
{
    protected $prefix = 'W';
    protected $fillable = [
        'code',
        'client_id',
        'notes',
        'start_date',
        'end_date',
        'tenant_id',
    ];

    public function client(){
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function work_details(){
        return $this->hasMany(WorkDetail::class)->withTrashed();
    }
}
