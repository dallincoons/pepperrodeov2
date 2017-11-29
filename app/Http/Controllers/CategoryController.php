<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::where('user_id', \Auth::user()->getKey())->get(), 200);
    }
}
