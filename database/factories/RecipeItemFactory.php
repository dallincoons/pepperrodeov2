<?php

use App\Entities\Recipe;
use App\Entities\RecipeItem;

$factory->define(RecipeItem::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence,
        'listable' => 0,
        'quantity' => $faker->randomDigit,
        'recipe_id' => function () {
            return Recipe::first() ?: factory(Recipe::class)->create();
        }
    ];
});
