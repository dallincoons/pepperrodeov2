<?php

namespace App\Repositories;

use App\Entities\Ingredient;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Illuminate\Foundation\Application;
use Prettus\Repository\Eloquent\BaseRepository;

class RecipeRepositoryEloquent extends BaseRepository implements RecipeRepository
{
    private $ingredientRepository;

    public function __construct(Application $app, IngredientRepositoryEloquent $repository)
    {
        parent::__construct($app);

        $this->ingredientRepository = $repository;
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
            ListableIngredient::create([
                    'recipe_id' => $recipe->getKey()
                ] + $ingredient);
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
