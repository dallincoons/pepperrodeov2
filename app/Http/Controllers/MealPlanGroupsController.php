<?php

namespace App\Http\Controllers;

use App\Criteria\AuthUserCriteria;
use App\MealPlanDay;
use App\MealPlanGroup;
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

        $mealPlanningGroups=  $this->repository->all();

        return response()->json($mealPlanningGroups, 200);
    }

    public function store(Request $request)
    {
        $scheduledRecipes = $request->input('scheduled_recipes');

        $mealPlanningGroup = MealPlanGroup::create(['user_id' => auth()->user()->getKey()]);

        foreach ($scheduledRecipes as $date => $recipes) {
            foreach ($recipes as $recipe) {
                MealPlanDay::create([
                    'meal_plan_group_id' => $mealPlanningGroup->getKey(),
                    'recipe_id' => (int)$recipe['id'],
                    'date' => $date,
                ]);
            }
        }

        return response()->json(['meal_planning_group' => $mealPlanningGroup]);
    }
}
