<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    const DEFAULT_DEPT_NAME = 'Unassigned';

    protected $fillable = [
        'name'
    ];

    public function scopeDefault($query)
    {
        return $query->first();
    }
}
