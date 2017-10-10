<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title', 'user_id'
    ];

    public function items()
    {
        return $this->hasMany(RecipeItem::class);
    }
}

