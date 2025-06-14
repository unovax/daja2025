<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkDetail extends BaseModel
{
    protected $prefix = 'WD';
    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'start_date',
        'end_date',
        'photo',
        'is_new',
        'work_id',
    ];

    public function work(){
        return $this->belongsTo(Work::class)->withTrashed();
    }

    public function measures(){
        return $this->belongsToMany(WorkDetail::class)->withTrashed();
    }
}
