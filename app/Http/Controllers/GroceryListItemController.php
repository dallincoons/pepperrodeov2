<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroceryListItemRequest;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Http\Request;

class GroceryListItemController extends Controller
{
    private $repository;

    public function __construct(GroceryListItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(CreateGroceryListItemRequest $request)
    {
        $item = $this->repository->create($request->all());

        return response()->json($item, 201);
    }

    public function delete(Request $request)
    {
        $success = $this->repository->delete($request->id);

        return response()->json($success, 200);
    }
}
