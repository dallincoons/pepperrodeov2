<?php

namespace App\Entities;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'directions',
        'category_id', 'prep_time',
        'total_time', 'serves',
        'user_id'
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function listableIngredients()
    {
        return $this->hasMany(ListableIngredient::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

