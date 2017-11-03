<?php

use App\Category;
use App\Entities\Recipe;
use App\User;

$factory->define(Recipe::class, function (Faker\Generator $faker) {
    $user = User::first() ?: factory(User::class)->create();
    $category = Category::first() ?: factory(Category::class)->create();
    return [
        'title' => $faker->sentence,
        'user_id' => $user->getKey(),
        'directions' => $faker->paragraph,
        'category_id' => $category->getKey(),
    ];
});

