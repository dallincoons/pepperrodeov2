<?php

namespace App\Repositories;

use App\Entities\ListableIngredient;
use Prettus\Repository\Eloquent\BaseRepository;

class ListableIngredientRepositoryEloquent extends BaseRepository implements IngredientRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return ListableIngredient::class;
    }
}
