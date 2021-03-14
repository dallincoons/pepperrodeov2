<?php

namespace App\Features\MealPlans;

use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class MealPlanBuilder
{
    public function create(array $schedule)
    {
        $dates = array_keys($schedule);

        $mealPlanningGroup = MealPlanGroup::create([
            'user_id' => auth()->user()->getKey(),
            'name' => $this->createName($dates),
            'start_date' => Arr::first($dates),
            'end_date' => Arr::last($dates),
        ]);

        foreach ($schedule as $date => $stuff) {
            foreach (Arr::get($stuff, 'recipes', []) as $recipe) {
                MealPlanDay::create([
                    'meal_plan_group_id' => $mealPlanningGroup->getKey(),
                    'recipe_id' => (int)$recipe['id'],
                    'date' => $date,
                ]);
            }

            foreach (Arr::get($stuff, 'items', []) as $item) {
                MealPlanItem::create([
                    'meal_plan_group_id' => $mealPlanningGroup->getKey(),
                    'title' => $item,
                    'date' => $date,
                ]);
            }
        }

        return $mealPlanningGroup;
    }

    private function createName(array $dates): string {
        $firstDay = Carbon::parse(Arr::first($dates));
        $lastDay = Carbon::parse(Arr::last($dates));

        return vsprintf("%s - %s", [$firstDay->format('F d'), $lastDay->format('F d')]);
    }
}
