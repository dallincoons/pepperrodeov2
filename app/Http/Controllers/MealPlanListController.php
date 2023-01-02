<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\MealPlanGroup;
use App\Repositories\GroceryListItemRepository;

class MealPlanListController extends Controller {

    public function store($groupID, $request)
    {
        $mealPlanGroupQuery = MealPlanGroup::query()

            ->firstOrFail();

        $mealPlanGroupQuery = MealPlanGroup::query()
            ->where('id', $groupID)
            ->whereDate('start_date', ">=", $request->start_date)
            ->whereDate('end_date', "<=", $request->end_date)
            ->with('days.recipe')
            ->with('items');

        if ($request->start_date) {
            $mealPlanGroupQuery->whereDate("start_date", ">=", $request->start_date);
        }

        if ($request->end_date) {
            $mealPlanGroupQuery->whereDate("end_date", "<=", $request->start_date);
        }

        $mealPlanGroup = $mealPlanGroupQuery->firstOrFail();

        $items = $mealPlanGroup->items;

        $grocerylist = GroceryList::create(['title' => $mealPlanGroup->name, 'user_id' => $mealPlanGroup->user_id]);

        $mealPlanGroup->days->each(function($day) use($grocerylist) {
            $grocerylist->addRecipe($day->recipe, $day->category_id);
        });

        $itemRepository = app(GroceryListItemRepository::class);

        foreach ($items as $item) {
            if (!$item->add_to_list) {
                continue;
            }

            $itemRepository->create([
                'grocery_list_id' => $grocerylist->getKey(),
                'description'   => $item->title,
                'quantity'      => 1,
                'department_id' => Department::DEFAULT_DEPT_ID,
            ]);
        }

        return response()->json(['grocerylist' => $grocerylist], 201);
    }
}
