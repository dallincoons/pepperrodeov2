<?php

namespace App\Http\Controllers;

use App\Entities\Recipe;
use Illuminate\Http\Request;

class RecipeSearchController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Recipe::search($request->get('query'))->get());
    }
}
