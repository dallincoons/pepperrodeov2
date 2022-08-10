<?php

use App\Entities\GroceryList;
use App\Entities\GroceryListItemGroup;
use App\Entities\Recipe;

$factory->define(GroceryListItemGroup::class, function (Faker\Generator $faker) {
    return  [
        'recipe_id' => function () { return factory(Recipe::class)->create(); },
        'grocery_list_id' => function () { return factory(GroceryList::class)->create(); },
        'category_id' => function () { return \App\Category::first() ?: factory(\App\Category::class)->create(); },
    ];
});
