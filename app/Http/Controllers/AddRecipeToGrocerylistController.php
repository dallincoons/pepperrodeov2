<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Recipe;
use Illuminate\Http\Request;

class AddRecipeToGrocerylistController extends Controller
{
    public function store(Request $request, Grocerylist $grocerylist)
    {
        //@todo add custom request validation to check if recipes exist
        $recipes = Recipe::whereIn('id', $request->recipes)->with('categories')->get();

        foreach($recipes as $recipe) {
            $grocerylist->addRecipe($recipe, $recipe->categories->first()->category_id);
        }

        return response()->json(['list' => $grocerylist, 'recipes_added' => $recipes], 200);
    }
}
