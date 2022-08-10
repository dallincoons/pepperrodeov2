<?php

namespace App\Http\Controllers;

use App\Entities\CompositeItem;
use App\Entities\GroceryListItem;
use App\Http\Requests\CreateGroceryListItemRequest;
use App\Http\Requests\UpdateGroceryListItemRequest;
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

    public function update(UpdateGroceryListItemRequest $request)
    {
        $items = GroceryListItem::where([
            'description' => $request->description,
            'grocery_list_id' => $request->grocery_list_id,
        ])->get();

       $item = new CompositeItem($items);

        if ($request->filled('department_id'))
        {
            $item->updateDepartment($request->department_id);
        }

        if ($request->filled('new_description'))
        {
            $item->updateDescription($request->new_description);
        }

        return response()->json($item, 200);
    }

    public function delete(Request $request, $itemId)
    {
        $success = $this->repository->delete($itemId);

        return response()->json($success, 200);
    }
}
