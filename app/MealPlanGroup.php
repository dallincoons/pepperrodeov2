<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealPlanGroup extends Model
{
    protected $fillable = [
        'name', 'user_id', 'start_date', 'end_date', 'grocery_list_id',
    ];

    public function recipes()
    {
        return $this->hasMany(MealPlanDay::class, 'meal_plan_group_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(MealPlanItem::class, 'meal_plan_group_id', 'id');
    }
}
