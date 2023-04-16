<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Features\MealPlanToList\DateFilter;
use App\Features\MealPlanToList\ListFromMealPlanBuilder;
use App\Http\Requests\MealPlanListStoreRequest;
use App\MealPlanGroup;

class MealPlanListController extends Controller {

    public function store(MealPlanListStoreRequest $request, $mealPlanId)
    {
        $mealPlanGroupQuery = MealPlanGroup::query()
            ->where('id', $mealPlanId)
            ->with('days.recipe.listableIngredients')
            ->with('items');

        $mealPlanGroup = $mealPlanGroupQuery->firstOrFail();

        $name = $mealPlanGroup->name;
        if ($request->name) {
            $name = $request->name;
        }

        $startDate = $request->getStartDate($mealPlanGroup);
        $endDate = $request->getEndDate($mealPlanGroup);

        $builder = new ListFromMealPlanBuilder($mealPlanGroup, new DateFilter($startDate, $endDate));

		$grocerylist = $builder->buildList($name);

        return response()->json(['grocerylist' => $grocerylist], 201);
    }
}
