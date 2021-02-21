<?php

namespace App\Features\Recipes;

use App\Entities\Recipe;
use App\LinkedRecipe;

class RecipeLinker
{
    public static function link(string $sourceID, string $destinationID)
    {
        return LinkedRecipe::create([
            'source_recipe_id' => $sourceID,
            'destination_recipe_id' => $destinationID,
        ]);
    }
}
