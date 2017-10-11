<?php

namespace Tests\Fakers;

use App\Entities\Recipe;
use App\Entities\RecipeItem;

class RecipeFaker
{
    public static function withItems($count = 1)
    {
        $recipe = factory(Recipe::class)->create();

        foreach(range(1, $count) as $i) {
            $item = factory(RecipeItem::class)->create([
                'recipe_id' => $recipe->getKey()
            ]);
            $recipe->items()->save($item);
        }

        return $recipe;
    }
}
