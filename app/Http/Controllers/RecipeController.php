<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Criteria\WithoutSubRecipesCriteria;
use App\Entities\Recipe;
use App\Features\Recipes\RecipeLinker;
use App\Http\Requests\Recipes\StoreRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Repositories\RecipeRepository;
use App\Repositories\RecipeRepositoryEloquent;
use Illuminate\Support\Arr;

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
        $this->repository->pushCriteria(new WithoutSubRecipesCriteria());

        $recipes = $this->repository->with('category')->orderBy('title')->all();

        return response()->json($recipes, 200);
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['ingredients', 'ingredients.department', 'listableIngredients', 'category', 'linkedRecipes']);
        $subRecipes = $this->repository->getSubRecipes($recipe);

        return response()->json(['recipe' => $recipe, 'sub_recipes' => $subRecipes], 200);
    }

    public function store(StoreRequest $request)
    {
        $recipe = $this->repository->create([
            'title'                => $request->title,
            'directions'           => $request->directions,
            'prep_time'            => $request->prep_time,
            'total_time'           => $request->total_time,
            'serves'               => $request->serves,
            'source'               => $request->source,
            'category_id'          => $request->category_id,
            'user_id'              => \Auth::user()->getKey(),
            'ingredients'          => $request->ingredients,
            'listable_ingredients' => $request->listable_ingredients,
            'sub_recipe'           => $request->sub_recipe,
        ]);

        if ($request->has('sub_recipes')) {
            foreach ($request->input('sub_recipes') as $subRecipe) {
                $this->repository->create([
                    'parent_id' => $recipe->getKey(),
                    'category_id' => $recipe->category_id,
                    'user_id' => $recipe->user_id,
                    'ingredients' => Arr::get($subRecipe, 'ingredients'),
                    'listable_ingredients' => Arr::get($subRecipe, 'listable_ingredients'),
                    'title' => Arr::get($subRecipe, 'title'),
                    'directions' => Arr::get($subRecipe, 'directions'),
                ]);
            }
        }

        if ($request->has('linked_recipes')) {
            foreach ($request->input('linked_recipes') as $linkRecipeID) {
                RecipeLinker::link($recipe->getKey(), $linkRecipeID);
            }
        }

        return response()->json($recipe, 201);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->repository->update($request->all(), $recipe->getKey());

        if ($request->has('sub_recipe')) {
            $subRecipe = $request->sub_recipe;
            $this->repository->update(array_filter([
                'parent_id'            => $recipe->getKey(),
                'category_id'          => $recipe->category_id,
                'user_id'              => $recipe->user_id,
                'ingredients'          => Arr::get($subRecipe, 'ingredients'),
                'listable_ingredients' => Arr::get($subRecipe, 'listable_ingredients'),
                'title'                => Arr::get($subRecipe, 'title'),
                'directions'           => Arr::get($subRecipe, 'directions'),
            ]), Arr::get($subRecipe, 'id'));
        }

        return response()->json($recipe->fresh(), 200);
    }

    public function delete(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json('Recipe with id: ' . $recipe->getKey() . ' has been deleted', 200);
    }
}
