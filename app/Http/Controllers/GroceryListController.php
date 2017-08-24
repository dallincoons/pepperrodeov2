<?php

namespace App\Http\Controllers;

use App\GroceryList;
use App\Http\Requests\GroceryListCreateRequest;
use App\Repositories\GroceryListRepository;
use Illuminate\Http\Request;

class GroceryListController
{
    public function all()
    {
        $grocerylists = GroceryListRepository::all();

        return response()->json($grocerylists, 200);
    }

    public function show(GroceryList $grocerylist)
    {
        $grocerylist->load('items');

        return response()->json($grocerylist, 200);
    }

    public function store(GroceryListCreateRequest $request)
    {
        $grocerylist = GroceryListRepository::store([
            'title'   => $request->title,
            'user_id' => \Auth::user()->getKey(),
            'items' => $request->items
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
