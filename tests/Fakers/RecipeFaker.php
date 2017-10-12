<?php

namespace Tests\Fakers;

use App\Entities\Recipe;
use App\Entities\RecipeItem;

class RecipeFaker
{
    public static function withItems($param = 1)
    {
        if (is_numeric($param)) {
            $list = self::withItemCount($param);
        } elseif (is_array($param)) {
            $list = self::withItemArray($param);
        } else {
            $list = factory(Recipe::class)->create();
        }

        return $list;
    }

    public static function withItemCount($count)
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

    public static function withItemArray(array $array)
    {
        $recipe = factory(Recipe::class)->create();

        if(count($array) == count($array, COUNT_RECURSIVE)) {
            $array = [$array];
        }

        foreach($array as $item) {
            $itemData = array_merge($item, [
                'recipe_id' => $recipe->getKey(),
            ]);
            $item = factory(RecipeItem::class)->create($itemData);
            $recipe->items()->save($item);
        }

        return $recipe;
    }
}
