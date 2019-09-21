<?php

namespace App\Http\Controllers;

use App\Entities\Recipe;

class DeletedRecipesController extends Controller
{
    public function index()
    {
        return response()->json(Recipe::withTrashed()->get());
    }
}
