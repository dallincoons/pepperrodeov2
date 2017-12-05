<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Http\Requests\AddRecipeRequest;
use App\Repositories\RecipeRepositoryEloquent;

class GroceryListRecipeController extends Controller
{
    /**
     * @var RecipeRepositoryEloquent
     */
    private $repository;

    public function __construct(RecipeRepositoryEloquent $repository)
    {
        $this->repository = $repository;
    }

    public function post(GroceryList $grocerylist, AddRecipeRequest $request)
    {
        foreach($request->input('recipes') as $recipeId) {
            try{
                $recipe = $this->repository->find($recipeId);

                $grocerylist->addRecipe($recipe);
            } catch (\Exception $e) {
                //
            }
        }
    }
}
