<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroceryListItemRequest;
use App\Http\Requests\UpdateGroceryListItemRequest;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Http\Request;

class GroceryListItemController extends Controller
{
    /**
     * @var GroceryListItemRepository
     */
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

    public function update(UpdateGroceryListItemRequest $request)
    {
        if ($request->ids !== null) {
            $ids = $request->ids;
            $request = $request->except(['ids', 'magic_description']);
        } else {
            $ids = [$request->id];
            $request = $request->except('ids');
        }

        foreach ($ids as $id) {
            $item = $this->repository->update($request, $id);
        }

        return response()->json($item, 200);
    }

    public function delete(Request $request, $itemId)
    {
        $success = $this->repository->delete($itemId);

        return response()->json($success, 200);
    }
}
