<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealPlanGroup extends Model
{
    protected $fillable = [
        'name', 'user_id', 'grocery_list_id'
    ];
}
