<?php

use App\Category;
use App\CategoryRecipe;
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

$factory->afterCreating(Recipe::class, function ($recipe, $faker) {
    if (!$recipe->category_id) {
        $category = Category::first() ?: factory(Category::class)->create();
        factory(CategoryRecipe::class)->create([
            'recipe_id' => $recipe->getKey(),
            'category_id' => $category->getKey(),
        ]);
    }
});
