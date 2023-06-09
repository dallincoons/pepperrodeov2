<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entities\GroceryList;
use Illuminate\Http\Request;

class GroceryListDepartmentController
{
	function delete(Request $request, GroceryList $grocerylist, $departmentId)
	{
		$grocerylist->items()->where('department_id', $departmentId)->delete();

		$grocerylist->append('combinedItems', 'recipes');

		return response()->json([
			'list' => $grocerylist,
			'recipes' => $grocerylist->recipes,
			'items' => $grocerylist->combinedItems
		]);
	}
}
