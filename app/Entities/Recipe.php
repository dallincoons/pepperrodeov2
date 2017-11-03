<?php

namespace App\Entities;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title', 'directions', 'category_id', 'user_id'
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

