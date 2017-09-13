<?php

use App\Entities\Department;

$factory->define(Department::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
