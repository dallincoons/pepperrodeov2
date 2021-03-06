<?php

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;

$factory->define(GroceryListItem::class, function (Faker\Generator $faker) {
    $groceryList = GroceryList::first() ?: factory(GroceryList::class)->create();

    return [
        'grocery_list_id' => $groceryList->getKey(),
        'department_id' => function () {
            $department = Department::first() ?: factory(Department::class)->create();
            return $department = $department->getKey();
        },
        'description' => $faker->sentence(5),
        'quantity' => $faker->randomDigit,
        'is_checked' => 0
    ];
});

