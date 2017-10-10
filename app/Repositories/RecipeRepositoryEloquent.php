<?php

namespace App\Repositories;

use App\Entities\Recipe;
use App\Entities\RecipeItem;
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

        $items = array_get($attributes, 'items') ?: [];

        foreach($items as $item){
            RecipeItem::create([
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
        return Recipe::class;
    }
}
