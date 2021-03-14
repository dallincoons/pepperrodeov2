<?php

namespace App;

use App\Entities\Recipe;
use Illuminate\Database\Eloquent\Model;

class MealPlanItem extends Model
{
    protected $fillable = [
        'meal_plan_group_id', 'title', 'date',
    ];
}
