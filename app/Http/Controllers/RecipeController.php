<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Entities\Recipe;
use App\Http\Requests\Recipes\StoreRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Repositories\RecipeRepository;
use App\Repositories\RecipeRepositoryEloquent;

class RecipeController extends Controller
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
        $this->repository->pushCriteria(new AuthUserCriteria());

        $recipes = $this->repository->with('category')->all();

        return response()->json($recipes, 200);
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['ingredients', 'ingredients.department', 'listableIngredients', 'category']);

        return response()->json($recipe, 200);
    }

    public function store(StoreRequest $request)
    {
        $recipe = $this->repository->create([
            'title'                => $request->title,
            'directions'           => $request->directions,
            'prep_time'            => $request->prep_time,
            'total_time'           => $request->total_time,
            'serves'               => $request->serves,
            'category_id'          => $request->category_id,
            'user_id'              => \Auth::user()->getKey(),
            'ingredients'          => $request->ingredients,
            'listable_ingredients' => $request->listable_ingredients,
        ]);

        return response()->json($recipe, 201);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->repository->update($request->all(), $recipe->getKey());

        return response()->json($recipe->fresh(), 200);
    }

    public function delete(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json('Recipe with id: ' . $recipe->getKey() . ' has been deleted', 200);
    }
}
