<?php

namespace App\Models;


class Unit extends BaseModel
{
    protected $prefix = 'UN';
    protected $fillable = ['code', 'name', 'tenant_id'];
}
