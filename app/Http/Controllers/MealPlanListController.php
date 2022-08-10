<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\MealPlanGroup;
use App\Repositories\GroceryListItemRepository;

class MealPlanListController extends Controller {

    public function store($groupID)
    {
        $mealPlanGroup = MealPlanGroup::query()
            ->where('id', $groupID)
            ->with('days.recipe')
            ->with('items')
            ->firstOrFail();

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
