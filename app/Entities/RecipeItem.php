<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    protected $fillable = [
        'recipe_id', 'quantity'
    ];
}
