<?php

namespace App\Http\Controllers;

use App\Entities\Recipe;
use App\Repositories\RecipeRepository;
use App\Repositories\RecipeRepositoryEloquent;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * @var RecipeRepositoryEloquent
     */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $recipes = $this->repository->all();

        return response()->json($recipes, 200);
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['items']);

        return response()->json($recipe, 200);
    }

    public function store(Recipe $recipe, Request $request)
    {
        foreach($request->get('ingredients', []) as $ingredient) {
            $this->repository->addIngredient($ingredient);
        }

        foreach($request->get('listable_ingredients', []) as $ingredient) {
            $this->repository->addListableIngredient($ingredient);
        }

        return response()->json($recipe, 201);
    }

    public function delete(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json('Recipe with id: ' . $recipe->getKey() . ' has been deleted', 200);
    }
}
