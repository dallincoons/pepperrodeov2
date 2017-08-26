<?php

namespace App\Http\Controllers;

use App\Entities\GroceryListItem;

class GroceryListItemCompletionController extends Controller
{
    public function store(GroceryListItem $groceryListItem)
    {
        $updatedItem = $groceryListItem->toggleComplete();

        return response()->json($updatedItem, 200);
    }
}
