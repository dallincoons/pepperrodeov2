<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title', 'user_id'
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}

