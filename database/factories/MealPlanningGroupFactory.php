<?php

use App\User;

$factory->define(\App\MealPlanGroup::class, function (Faker\Generator $faker) {
    $user = User::first() ?: factory(User::class)->create();
    return [
        'grocery_list_id' => create(\App\Entities\GroceryList::class),
        'user_id' => $user->getKey(),
        'name' => 'abd123',
        'start_date' => \Carbon\Carbon::now()->isoFormat("YYYY-MM-DD"),
        'end_date' => \Carbon\Carbon::now()->isoFormat("YYYY-MM-DD"),
    ];
});

