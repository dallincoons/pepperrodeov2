<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/products",
     *   summary="list products",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function all()
    {
        return response()->json(Category::where('user_id', \Auth::user()->getKey())->get(), 200);
    }
}
