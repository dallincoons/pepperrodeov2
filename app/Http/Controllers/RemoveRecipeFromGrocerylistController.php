<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Recipe;

class RemoveRecipeFromGrocerylistController
{
    public function __invoke(GroceryList $grocerylist, Recipe $recipe)
    {
        try {
            $grocerylist->removeRecipe($recipe);
        } catch (\Throwable $e) {
            return response($e->getMessage());
        }

        return response('success');
    }
}
