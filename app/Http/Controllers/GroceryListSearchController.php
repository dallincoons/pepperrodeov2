<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use Illuminate\Http\Request;

class GroceryListSearchController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(GroceryList::search($request->get('query'))->get());
    }
}
