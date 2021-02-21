<?php

namespace App\Entities;

use App\Category;
use App\LinkedRecipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Recipe extends Model
{
    use SoftDeletes, Searchable;

    const SOURCE_TYPE_TEXT = 1;
    const SOURCE_TYPE_URL = 2;

    protected $fillable = [
        'title', 'directions',
        'category_id', 'prep_time',
        'total_time', 'serves',
        'user_id', 'parent_id',
        'source'
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function listableIngredients()
    {
        return $this->hasMany(ListableIngredient::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function linkedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'linked_recipes', 'source_recipe_id', 'destination_recipe_id');
    }

    public function setSourceAttribute($source)
    {
        $this->attributes['source'] = $source;

        if (filter_var($source, FILTER_VALIDATE_URL)) {
            $this->source_type = self::SOURCE_TYPE_URL;
            return;
        }

        $this->source_type = self::SOURCE_TYPE_TEXT;
    }
}

