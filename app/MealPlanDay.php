<?php

namespace App;

use App\Entities\Recipe;
use Illuminate\Database\Eloquent\Model;

class MealPlanDay extends Model
{
    protected $fillable = [
        'meal_plan_group_id', 'recipe_id', 'category_id', 'date',
    ];

    public function recipe()
    {
        return $this->hasOne(Recipe::class, 'id', 'recipe_id')->withTrashed();
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->withTrashed();
    }
}
