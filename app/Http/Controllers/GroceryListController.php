<?php

namespace App\Http\Controllers;

use App\GroceryList;
use Illuminate\Http\Request;

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
}
