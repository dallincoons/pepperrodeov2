<?php

namespace App\Features\Categories;

use App\Category;
use App\User;

class DefaultCategories
{
    protected static $defaultCategoryNames = [
        'Breakfast',
        'Lunch',
        'Dinner',
        'Trying',
        'Don\'t like',
    ];

    public static function save()
    {
        foreach (self::$defaultCategoryNames as $name) {
            factory(Category::class)->create([
                'title' => $name,
                'user_id' => User::first()->getKey()
            ]);
        }
    }
}
