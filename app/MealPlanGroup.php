<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealPlanGroup extends Model
{
    protected $fillable = [
        'user_id', 'grocery_list_id'
    ];
}
