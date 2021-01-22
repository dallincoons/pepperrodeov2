<?php

namespace App;

use App\Entities\Recipe;
use Illuminate\Database\Eloquent\Model;

class MealPlanDay extends Model
{
    protected $fillable = [
        'meal_plan_group_id', 'recipe_id', 'date',
    ];
}
