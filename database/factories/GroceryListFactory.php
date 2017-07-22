<?php

use App\GroceryList;
use App\User;

$factory->define(GroceryList::class, function (Faker\Generator $faker) {
    $user = User::first() ?: factory(User::class)->create();
    return [
        'title' => $faker->sentence,
        'user_id' => $user->getKey()
    ];
});
