<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkDetailMeasure extends BaseModel
{
    protected $prefix = 'WDM';
    protected $fillable = ['code', 'work_detail_id', 'measure_id'];

    public function measure(){
        return $this->belongsTo(Measure::class)->withTrashed();
    }
    public function work_detail(){
        return $this->belongsTo(WorkDetail::class)->withTrashed();
    }

}
