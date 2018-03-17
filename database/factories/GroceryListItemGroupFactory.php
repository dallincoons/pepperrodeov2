<?php

use App\Entities\GroceryListItemGroup;
use App\Entities\Recipe;

$factory->define(GroceryListItemGroup::class, function (Faker\Generator $faker) {
    return  [
        'recipe_id' => factory(Recipe::class)->create()
    ];
});
