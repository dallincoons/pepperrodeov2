<?php

namespace App\Repositories;

use App\Entities\Ingredient;
use App\Entities\Recipe;
use Prettus\Repository\Eloquent\BaseRepository;

class RecipeRepositoryEloquent extends BaseRepository implements RecipeRepository
{
    /**
     * @param array $attributes
     * @return Recipe
     */
    public function create(array $attributes)
    {
        $recipe = parent::create($attributes);

        $ingredients = array_get($attributes, 'ingredients') ?: [];

        foreach($ingredients as $ingredient){
            Ingredient::create([
                    'recipe_id' => $recipe->getKey()
                ] + $ingredient);
        }

        return $recipe;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Recipe::class;
    }
}
