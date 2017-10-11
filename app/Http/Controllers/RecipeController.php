<?php

namespace App\Http\Controllers;

use App\Entities\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
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

    public function store(Request $request)
    {
        $recipe = $this->repository->create([
            'title' => $request->title,
            'user_id' => \Auth::user()->getKey(),
            'items' => $request->items
        ]);

        return response()->json($recipe, 201);
    }

    public function delete(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json('Recipe with id: ' . $recipe->getKey() . ' has been deleted', 200);
    }
}
