<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $recipe = $this->repository->create([
            'title' => $request->title,
            'user_id' => \Auth::user()->getKey(),
            'items' => $request->items
        ]);

        return response()->json($recipe, 201);
    }
}
