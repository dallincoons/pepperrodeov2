<?php

use App\Entities\Ingredient;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        foreach(range(1, 5) as $i) {
            $recipe = factory(Recipe::class)->create();
            $recipe->listableIngredients()->save(factory(ListableIngredient::class)->create());
            $recipe->ingredients()->save(factory(Ingredient::class)->create());
        }
    }
}
