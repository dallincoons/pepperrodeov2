<?php

use App\User;

$factory->define(\App\MealPlanItem::class, function (Faker\Generator $faker) {
    return [
        'meal_plan_group_id' => create(\App\MealPlanGroup::class),
        'title' => str_random(),
        'date' => '2020-01-01',
    ];
});


