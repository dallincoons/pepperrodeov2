<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Http\Requests\MealPlanListStoreRequest;
use App\MealPlanGroup;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Http\Request;

class MealPlanListController extends Controller {

    public function store(MealPlanListStoreRequest $request, $groupID)
    {
        $mealPlanGroupQuery = MealPlanGroup::query()
            ->where('id', $groupID)
            ->with('days.recipe')
            ->with('items');

        $mealPlanGroup = $mealPlanGroupQuery->firstOrFail();

        $items = $mealPlanGroup->items;

        $name = $mealPlanGroup->name;
        if ($request->name) {
            $name = $request->name;
        }

        $grocerylist = GroceryList::create(['title' => $name, 'user_id' => $mealPlanGroup->user_id]);

        $daysQuery = $mealPlanGroup->days();

        $daysQuery->whereDate("date", ">=", $request->getStartDate($mealPlanGroup));
        $daysQuery->whereDate("date", "<=", $request->getEndDate($mealPlanGroup));

        $daysQuery->get()->each(function($day) use($grocerylist) {
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
