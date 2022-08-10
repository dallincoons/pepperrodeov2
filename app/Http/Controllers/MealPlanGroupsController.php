<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Features\MealPlans\MealPlanBuilder;
use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use App\Repositories\MealPlanningGroupRepository;
use Illuminate\Http\Request;

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

        $mealPlanningGroups=  $this->repository->scopeQuery(function($query){
            return $query->orderBy('created_at','desc');
        })->all();

        return response()->json($mealPlanningGroups, 200);
    }

    public function store(Request $request)
    {
        $schedule = $request->input('schedule');
        $extraItems = $request->input('extraItems', []);

        $builder = new MealPlanBuilder();

        return response()->json(['meal_planning_group' => $builder->create($schedule, $extraItems)]);
    }

    public function show(Request $request, $groupID)
    {
        $result = [];

        $group = MealPlanGroup::findOrFail($groupID);
        $dayRecipes = MealPlanDay::with('recipe')->with('category')->where('meal_plan_group_id', $groupID)->get();
        $dayItems = MealPlanItem::where('meal_plan_group_id', $groupID)->whereNotNull('date')->get();
        $extraItems = MealPlanItem::where('meal_plan_group_id', $groupID)->whereNull('date')->get();

        $dayRecipes->transform(function($recipe) {
            $recipe['id'] = $recipe->recipe_id;
            $recipe['category'] = $recipe->category;
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

        foreach ($dayItems->groupBy('date') as $date => $items) {
            if (!array_key_exists($date, $result)) {
                $result[$date] = [
                    'recipes' => [],
                    'items' => [],
                ];
            }

            $result[$date]['items'] = $items->map(function($item) {
                return [
                    'id' => $item->getKey(),
                    'title' => $item->title,
                ];
            });
        }

        return response()->json(['schedule' => $result, 'extraItems' => $extraItems, 'start_date' => $group->start_date, 'end_date' => $group->end_date]);
    }

    public function delete(Request $request, $groupId)
    {
        MealPlanGroup::where('id', $groupId)->delete();

        return response()->json([], 200);
    }

    public function update(Request $request, $groupId)
    {
        $mealPlanGroup = MealPlanGroup::where('id', $groupId)->firstOrFail();
        $schedule = $request->input('schedule', []);
        $adHocItems = $request->input('extraItems', []);

        $builder = new MealPlanBuilder();

        $builder->update($mealPlanGroup, $schedule, $adHocItems);

        $extraItems = MealPlanItem::where('meal_plan_group_id', $mealPlanGroup->getKey())->whereNull('date')->get();

        return response()->json(['meal_planning_group' => $mealPlanGroup, 'extraItems' => $extraItems], 200);
    }
}
