<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use SoftDeletes;
    public function tenant()
    {
        $this->belongsTo(Tenant::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
            $prefix = property_exists($model, 'prefix') ? $model->prefix : 'DAJA';
            $model->code = $prefix . self::count() + 1;
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('tenant_id', Auth::user()->tenant_id);
            }
        });
    }

    public function getNameAttribute($value)
    {
        if ($this->deleted_at) {
            return $value . ' (Eliminado)';
        }
        return $value;
    }
}
