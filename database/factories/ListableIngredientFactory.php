<?php

use App\Entities\Department;
use App\Entities\Recipe;

$factory->define(\App\Entities\ListableIngredient::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence,
        'quantity' => $faker->randomDigit,
        'department_id' => Department::default()->getKey(),
        'recipe_id' => function () {
            return Recipe::first() ?: factory(Recipe::class)->create();
        },
    ];
});

