<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\MealPlanGroup;

class MealPlanListController extends Controller {

    public function store($groupID)
    {
        $mealPlanGroup = MealPlanGroup::query()
            ->where('id', $groupID)
            ->with('days.recipe')
            ->first();

        $recipes = $mealPlanGroup->days->pluck('recipe');

        $grocerylist = GroceryList::create(['title' => $mealPlanGroup->name, 'user_id' => $mealPlanGroup->user_id]);

        $grocerylist->addRecipes($recipes->all());

        return response()->json(['grocerylist' => $grocerylist], 201);
    }
}
