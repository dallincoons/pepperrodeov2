<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all()
    {
        return response()->json(Category::where('user_id', \Auth::user()->getKey())->get(), 200);
    }
}
