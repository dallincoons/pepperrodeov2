<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;

class RecentGroceryListController extends Controller
{
    public function show()
    {
        $list = GroceryList::orderBy('created_at', 'desc')->first();

        $list->append('recipes');

        return response()->json($list);
    }
}
