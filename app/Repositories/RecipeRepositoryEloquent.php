<?php

namespace App\Repositories;

use App\Entities\Ingredient;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Illuminate\Foundation\Application;
use PhpOption\Option;
use Prettus\Repository\Eloquent\BaseRepository;

class RecipeRepositoryEloquent extends BaseRepository implements RecipeRepository
{
    /**
     * @var IngredientRepositoryEloquent
     */
    private $ingredientRepository;

    /**
     * @var ListableIngredientRepositoryEloquent
     */
    private $listableIngredientRepository;

    public function __construct(Application $app, IngredientRepositoryEloquent $repository, ListableIngredientRepositoryEloquent $listableIngredientRepository)
    {
        parent::__construct($app);

        $this->ingredientRepository = $repository;
        $this->listableIngredientRepository = $listableIngredientRepository;
    }

    public function getSubRecipes(Recipe $recipe)
    {
        return Recipe::with(['ingredients', 'listableIngredients', 'ingredients.department'])
            ->where('parent_id', $recipe->getKey())->get();
    }

    /**
     * @param array $attributes
     * @return Recipe
     */
    public function create(array $attributes)
    {
        $recipe = parent::create($attributes);

        $ingredients = array_get($attributes, 'ingredients') ?: [];
        $listableIngredients = array_get($attributes, 'listable_ingredients') ?: [];

        foreach($ingredients as $ingredient){
            $this->ingredientRepository->create([
                    'recipe_id' => $recipe->getKey()
                ] + $ingredient);
        }

        foreach($listableIngredients as $ingredient){
            $this->listableIngredientRepository->create([
                    'recipe_id' => $recipe->getKey()
                ] + $ingredient);
        }

        return $recipe;
    }

    /**
     * @param array $attributes
     * @param $recipeKey
     * @return Recipe
     */
    public function update(array $attributes, $recipeKey)
    {
        $recipe = parent::update($attributes, $recipeKey);

        $ingredients = array_get($attributes, 'ingredients', []);
        $listableIngredients = array_get($attributes, 'listable_ingredients', []);

        $existingIngredients = $this->ingredientRepository->where('recipe_id', $recipeKey)->get();
        $existingListableIngredients = $this->listableIngredientRepository->where('recipe_id', $recipeKey)->get();

        $ingredientsIDsToDelete = $existingIngredients->pluck('id')->diff(collect($ingredients)->pluck('id'));
        $listableIngredientsIDsToDelete = $existingListableIngredients->pluck('id')->diff(collect($listableIngredients)->pluck('id'));

        Ingredient::whereIn('id', $ingredientsIDsToDelete)->delete();
        ListableIngredient::whereIn('id', $listableIngredientsIDsToDelete)->delete();

        foreach($ingredients as $ingredient) {
            $keyOption = Option::fromValue(array_get($ingredient, 'id'));
            if($keyOption->isEmpty()) {
                $this->ingredientRepository->create(array_filter($ingredient) + ['recipe_id' => $recipeKey]);
            } else {
                $this->ingredientRepository->update(array_filter($ingredient), $keyOption->get());
            }
        }

        foreach($listableIngredients as $ingredient) {
            $keyOption = Option::fromValue(array_get($ingredient, 'id'));
            if($keyOption->isEmpty()) {
                $this->listableIngredientRepository->create(array_filter($ingredient) + ['recipe_id' => $recipeKey]);
            } else {
                $this->listableIngredientRepository->update(array_filter($ingredient), $keyOption->get());
            }
        }

        return $recipe;
    }

    public function addIngredient(array $ingredients)
    {
        Ingredient::create($ingredients);
    }

    public function addListableIngredient(array $ingredients)
    {
        ListableIngredient::create($ingredients);
    }

    /**
     * @return string
     */
    public function model()
    {
        return Recipe::class;
    }
}
