<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\Entities\Recipe;
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
        $scheduledRecipes = array_filter($request->input('scheduled_recipes'));

        $builder = new MealPlanBuilder();

        return response()->json(['meal_planning_group' => $builder->create($scheduledRecipes)]);
    }

    public function show(Request $request, $groupID)
    {
        $days = MealPlanGroup::query()
            ->where('id', $groupID)
            ->with('days')
            ->with('days.recipe.category')
            ->first()
            ->days;

        return response()->json(['days' => $days->groupBy('date')]);
    }

    public function delete(Request $request, $groupId)
    {
        MealPlanGroup::where('id', $groupId)->delete();

        return response()->json([], 200);
    }

    public function update(Request $request, $groupId)
    {
        return response()->json([], 200);
    }
}
