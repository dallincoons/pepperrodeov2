<?php

namespace App\Repositories;

use App\Entities\Ingredient;
use Prettus\Repository\Eloquent\BaseRepository;

class IngredientRepositoryEloquent extends BaseRepository implements IngredientRepository
{
    /**
     * @param array $attributes
     * @return Ingredient
     */
    public function create(array $attributes)
    {
        $recipe = parent::create($attributes);

        $items = array_get($attributes, 'items') ?: [];

        foreach($items as $item){
            Ingredient::create([
                    'recipe_id' => $recipe->getKey()
                ] + $item);
        }

        return $recipe;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Ingredient::class;
    }
}
