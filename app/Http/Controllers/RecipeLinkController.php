<?php

namespace App\Http\Controllers;

use App\Features\Recipes\RecipeLinker;
use App\Http\Requests\Recipes\RecipeLinkStore;
use App\Repositories\RecipeRepository;
use App\Repositories\RecipeRepositoryEloquent;
use Illuminate\Http\Request;

class RecipeLinkController extends Controller
{
    /**
     * @var RecipeRepositoryEloquent
     */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(RecipeLinkStore $request)
    {
        $success = RecipeLinker::link($request->getSourceRecipeID(), $request->getDestinationID());

        return response()->json([
            'success' => (bool) $success,
        ]);
    }
}
