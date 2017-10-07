<?php

namespace App\Repositories;

use App\Recipe;
use Prettus\Repository\Eloquent\BaseRepository;

class RecipeRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Recipe::class;
    }
}
