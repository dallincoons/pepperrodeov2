<?php

use App\Entities\Department;
use App\Entities\Recipe;

$factory->define(\App\Entities\Ingredient::class, function (Faker\Generator $faker) {
    return [
        'full_description' => $faker->randomDigit . ' ' . $faker->sentence,
        'department_id' => function () {
            $department = Department::first() ?: factory(Department::class)->create();
            return $department = $department->getKey();
        },
        'quantity' => $faker->randomDigit,
        'recipe_id' => function () {
            return Recipe::first() ?: factory(Recipe::class)->create();
        },
    ];
});
