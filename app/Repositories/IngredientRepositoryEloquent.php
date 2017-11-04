<?php

namespace App\Repositories;

use App\Entities\Ingredient;
use Prettus\Repository\Eloquent\BaseRepository;

class IngredientRepositoryEloquent extends BaseRepository implements IngredientRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Ingredient::class;
    }
}
