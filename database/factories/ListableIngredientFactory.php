<?php

use App\Entities\Department;
use App\Entities\Recipe;

$factory->define(\App\Entities\ListableIngredient::class, function (Faker\Generator $faker) {
    return [
        'full_description' => $faker->randomDigit . ' ' . $faker->sentence,
        'department_id' => Department::default()->getKey(),
        'recipe_id' => function () {
            return Recipe::first() ?: factory(Recipe::class)->create();
        },
    ];
});

