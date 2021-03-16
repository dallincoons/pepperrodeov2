<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Features\MealPlans\MealPlanBuilder;
use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use App\Repositories\MealPlanningGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MealPlanGroupsController extends Controller
{
    private $repository;

    public function __construct(MealPlanningGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->repository->pushCriteria(new AuthUserCriteria());

        $mealPlanningGroups=  $this->repository->all();

        return response()->json($mealPlanningGroups, 200);
    }

    public function store(Request $request)
    {
        $schedule = $request->input('schedule');

        $builder = new MealPlanBuilder();

        return response()->json(['meal_planning_group' => $builder->create($schedule)]);
    }

    public function show(Request $request, $groupID)
    {
        $result = [];

        $group = MealPlanGroup::findOrFail($groupID);
        $dayRecipes = MealPlanDay::with('recipe')->with('recipe.category')->where('meal_plan_group_id', $groupID)->get();
        $items = MealPlanItem::where('meal_plan_group_id', $groupID)->get();

        $dayRecipes->transform(function($recipe) {
            $recipe['category'] = $recipe->recipe->category;
            $recipe['title'] = $recipe->recipe->title;
            return $recipe;
        });

        foreach ($dayRecipes->groupBy('date') as $date => $recipes) {
            if (!array_key_exists($date, $result)) {
                $result[$date] = [
                    'recipes' => [],
                    'items' => [],
                ];
            }

            $result[$date]['recipes'] = $recipes;
        }

        foreach ($items->groupBy('date') as $date => $items) {
            if (!array_key_exists($date, $result)) {
                $result[$date] = [
                    'recipes' => [],
                    'items' => [],
                ];
            }

            $result[$date]['items'] = $items;
        }

        return response()->json(['schedule' => $result, 'start_date' => $group->start_date, 'end_date' => $group->end_date]);
    }

    public function delete(Request $request, $groupId)
    {
        MealPlanGroup::where('id', $groupId)->delete();

        return response()->json([], 200);
    }

    public function update(Request $request, $groupId)
    {
        $mealPlanGroup = MealPlanGroup::where('id', $groupId)->firstOrFail();
        $scheduledRecipes = $request->input('scheduled_recipes');

        $builder = new MealPlanBuilder();

        $builder->update($mealPlanGroup, $scheduledRecipes);

        return response()->json(['meal_planning_group' => $mealPlanGroup], 200);
    }
}
