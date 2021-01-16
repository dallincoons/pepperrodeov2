<?php

namespace App\Http\Controllers;

use App\Entities\Recipe;
use App\Repositories\RecipeRepository;
use App\Repositories\RecipeRepositoryEloquent;
use Illuminate\Http\Request;

class RecipeSearchController extends Controller
{
    /**
     * @var RecipeRepositoryEloquent
     */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $recipes = Recipe::search($request->get('query'))
            ->get()
            ->load('category');

        return response()->json($recipes);
    }
}
