<?php

namespace App\Http\Controllers;

use App\GroceryList;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class GroceryListController
{
    public function all()
    {
        $grocerylists = GroceryList::all();

        return response()->json($grocerylists, 200);
    }

    public function show(GroceryList $grocerylist)
    {
        return response()->json($grocerylist, 200);
    }

    public function store(Request $request)
    {
        $grocerylist = GroceryList::create([
            'title'   => $request->title,
            'user_id' => \Auth::user()->getKey()
        ]);

        return response()->json($grocerylist, 201);
    }

    public function delete(GroceryList $grocerylist)
    {
        $grocerylist->delete();

        return response()->json('Grocery list with id: ' . $grocerylist->getKey() . ' has been deleted', 200);
    }
}
