<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryRecipe extends Model
{
    protected $table = 'category_recipe';
    public $timestamps = false;

    protected $fillable = ['recipe_id', 'category_id'];
}
