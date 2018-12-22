<?php

namespace App\Http\Handlers;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateGroceryListDepartment extends Controller
{
    public function __invoke(Request $request, GroceryList $groceryList)
    {
        $items = $groceryList->getCombinedItems()->all();

        $description = $request->description;

        if (!array_key_exists($description, $items)) {
            return;
            //handle this condition
        }
        $items[$description]->updateDepartment($request->department_id);
    }
}
