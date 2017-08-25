<?php

namespace App\Http\Controllers;

use App\Entities\GroceryListItem;
use Illuminate\Http\Request;

class GroceryListItemCompletionController extends Controller
{
    public function store(GroceryListItem $groceryListItem)
    {
        $groceryListItem->toggleComplete();

        return response()->json($groceryListItem, 200);
    }
}
