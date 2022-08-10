<?php

$factory->define(\App\MealPlanDay::class, function (Faker\Generator $faker) {
    return [
        'meal_plan_group_id' => create(\App\MealPlanGroup::class),
        'recipe_id' => create(\App\Entities\Recipe::class),
        'category_id' => \App\CategoryRecipe::first()->category_id,
        'date' => \Carbon\Carbon::today()->format('YYYY-MM-DD'),
    ];
});

