<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    const DEFAULT_DEPT_NAME = 'Unassigned';
    const DEFAULT_DEPT_ID = 1;

    protected $fillable = [
        'name'
    ];

    public function scopeDefault($query)
    {
        return $query->first();
    }
}
