<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Entities\GroceryList;
use App\Http\Requests\GroceryListCreateRequest;
use App\Repositories\GroceryListRepository;
use App\Repositories\GroceryListRepositoryOld;
use Illuminate\Http\Request;

class GroceryListController
{
    private $repository;

    public function __construct(GroceryListRepository $groceryListRepository)
    {
       $this->repository = $groceryListRepository;
    }

    public function all()
    {
        $this->repository->pushCriteria(new AuthUserCriteria());

        $grocerylists =  $this->repository->all();

        return response()->json($grocerylists, 200);
    }

    public function show(Request $request, GroceryList $grocerylist)
    {
        $grocerylist->load(['items', 'items.department']);

        $grocerylist->append('combinedItems', 'recipes', 'uniqueRecipeCount');

        return response()->json($grocerylist, 200);
    }

    public function store(GroceryListCreateRequest $request)
    {
        $grocerylist = $this->repository->create([
            'title'   => $request->title,
            'user_id' => \Auth::user()->getKey(),
            'items'   => $request->items
        ]);

        return response()->json($grocerylist, 201);
    }

    public function delete(GroceryList $grocerylist)
    {
        $grocerylist->delete();

        return response()->json('Grocery list with id: ' . $grocerylist->getKey() . ' has been deleted', 200);
    }

    public function update(Request $request, GroceryList $grocerylist)
    {
        $grocerylist->update([
            'title' => $request->title
        ]);

        return response()->json($grocerylist, 200);
    }
}
