<?php

use App\Entities\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        foreach(range(1, 5) as $i) {
            factory(Recipe::class)->create();
        }
    }
}
