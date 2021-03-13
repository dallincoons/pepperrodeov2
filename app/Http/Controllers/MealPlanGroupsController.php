<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Features\MealPlans\MealPlanBuilder;
use App\MealPlanDay;
use App\MealPlanGroup;
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
        $scheduledRecipes = $request->input('scheduled_recipes');

        $builder = new MealPlanBuilder();

        return response()->json(['meal_planning_group' => $builder->create($scheduledRecipes)]);
    }

    public function show(Request $request, $groupID)
    {
        $group = MealPlanGroup::query()
            ->where('id', $groupID)
            ->with('days')
            ->with('days.recipe.category')
            ->first();

        return response()->json(['days' => $group->days->groupBy('date'), 'name' => $group->name, 'start_date' => $group->start_date, 'end_date' => $group->end_date]);
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
