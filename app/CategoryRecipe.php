<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryRecipe extends Pivot
{
    protected $table = 'category_recipe';
    public $timestamps = false;

    protected $fillable = ['recipe_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
