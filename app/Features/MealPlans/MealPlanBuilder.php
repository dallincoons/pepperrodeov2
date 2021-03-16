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

    public function update(MealPlanGroup $mealPlanGroup, array $scheduledRecipes)
    {
        $existingDays = $mealPlanGroup->days->groupBy('date')->all();

        foreach ($scheduledRecipes as $date => $scheduled) {
            if (!array_key_exists($date, $existingDays)) {
                foreach ($scheduled as $recipe) {
                    MealPlanDay::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'recipe_id' => (int)$recipe['id'],
                        'date' => $date,
                    ]);
                }
            } else {
                $existing = $existingDays[$date];

                $toDeleteIds = array_diff(Arr::pluck($existing, 'recipe_id'), Arr::pluck($scheduled, 'id'));

                MealPlanDay::where(['meal_plan_group_id' => $mealPlanGroup->getKey(), 'date' => $date])->whereIn('recipe_id', $toDeleteIds)->delete();

                $toAddIds = array_diff(Arr::pluck($scheduled, 'id'), Arr::pluck($existing, 'recipe_id'));

                foreach ($toAddIds as $toAddId) {
                    MealPlanDay::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'recipe_id' => $toAddId,
                        'date' => $date,
                    ]);
                }
            }
        }

        $datesToDelete = array_diff(array_keys($existingDays), array_keys($scheduledRecipes));

        MealPlanDay::whereIn('date', $datesToDelete)->where('meal_plan_group_id', $mealPlanGroup->getKey())->delete();
    }

    private function createName(array $dates): string {
        $firstDay = Carbon::parse(Arr::first($dates));
        $lastDay = Carbon::parse(Arr::last($dates));

        return vsprintf("%s - %s", [$firstDay->format('F d'), $lastDay->format('F d')]);
    }
}
