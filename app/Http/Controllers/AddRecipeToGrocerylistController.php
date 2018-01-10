<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Recipe;

class AddRecipeToGrocerylistController extends Controller
{
    public function store(Grocerylist $grocerylist, Recipe $recipe)
    {
        $grocerylist->addRecipe($recipe);

        return response()->json($grocerylist, 200);
    }
}
