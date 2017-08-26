<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroceryListItemRequest;
use App\Repositories\GroceryListItemRepository;

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
}
