<?php

namespace App\Http\Controllers;

use App\Entities\ListableIngredient;
use App\Repositories\ListableIngredientRepository;
use App\Repositories\ListableIngredientRepositoryEloquent;

class ListableIngredientController extends Controller
{
    /**
     * @var ListableIngredientRepositoryEloquent
     */
    private $repository;

    public function __construct(ListableIngredientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(ListableIngredient $ingredient)
    {
        $this->repository->delete($ingredient->getKey());

        return response()->json('Listable Ingredient with id: ' . $ingredient->getKey() . ' has been deleted', 200);
    }
}
