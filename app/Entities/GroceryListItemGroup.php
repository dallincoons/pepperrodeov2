<?php

namespace App\Entities;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class GroceryListItemGroup extends Model
{
    protected $fillable = [
        'recipe_id', 'grocery_list_id', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
