<?php

namespace App\Http\Controllers;

use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    private $repository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->repository = $recipeRepository;
    }

    public function store(Request $request)
    {
        $recipe = $this->repository->create([
           'title' => $request->title
        ]);

        return response()->json($recipe, 201);
    }
}
