<?php

use App\Category;
use App\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $defaultCategoryNames = [
            'Breakfast',
            'Lunch',
            'Dinner'
        ];

        $user = User::first();

        foreach ($defaultCategoryNames as $name) {
            factory(Category::class)->create([
                'title' => $name,
                'user_id' => $user->getKey()
            ]);
        }
    }
}
