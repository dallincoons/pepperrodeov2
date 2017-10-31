<?php

use App\Category;
use App\User;

$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'user_id' => \Auth::check() ? \Auth::user()->getKey() : User::first()->getKey()
    ];
});
