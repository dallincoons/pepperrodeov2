<?php

use App\Entities\Recipe;
use App\User;

$factory->define(Recipe::class, function (Faker\Generator $faker) {
    $user = User::first() ?: factory(User::class)->create();
    return [
        'title' => $faker->sentence,
        'user_id' => $user->getKey(),
        'directions' => $faker->paragraph,
    ];
});

