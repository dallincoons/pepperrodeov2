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

    public function update(MealPlanGroup $mealPlanGroup, array $schedule)
    {
        $existingRecipes = $mealPlanGroup->recipes->groupBy('date')->all();
        $existingItems = $mealPlanGroup->recipes->groupBy('date')->all();

        foreach ($schedule as $date => $scheduled) {
            $recipes = $scheduled['recipes'];
            $items = $scheduled['items'];
            if (!array_key_exists($date, $existingRecipes)) {
                foreach ($recipes as $recipe) {
                    MealPlanDay::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'recipe_id' => (int)$recipe['id'],
                        'date' => $date,
                    ]);
                }
            } else {
                $existing = $existingRecipes[$date];

                $toDeleteIds = array_diff(Arr::pluck($existing, 'recipe_id'), Arr::pluck($recipes, 'id'));

                MealPlanDay::where(['meal_plan_group_id' => $mealPlanGroup->getKey(), 'date' => $date])->whereIn('recipe_id', $toDeleteIds)->delete();

                $toAddIds = array_diff(Arr::pluck($recipes, 'id'), Arr::pluck($existing, 'recipe_id'));

                foreach ($toAddIds as $toAddId) {
                    MealPlanDay::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'recipe_id' => $toAddId,
                        'date' => $date,
                    ]);
                }
            }
        }

        $datesToDelete = array_diff(array_keys($existingRecipes), array_keys($schedule));

        MealPlanDay::whereIn('date', $datesToDelete)->where('meal_plan_group_id', $mealPlanGroup->getKey())->delete();

//        $this->syncItems($existingItems, $schedule, $mealPlanGroup);
    }

    private function syncItems($existingItems, $schedule, MealPlanGroup $mealPlanGroup) {
        foreach ($schedule as $date => $scheduled) {
            $items = $scheduled['items'];
            if (!array_key_exists($date, $existingItems)) {
                foreach ($items as $item) {
                    MealPlanItem::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'title' => (int)$item,
                        'date' => $date,
                    ]);
                }
            } else {
//                $existing = $existingItems[$date];
//
//                $toDeleteIds = array_diff(Arr::pluck($existing, 'recipe_id'), Arr::pluck($items, 'id'));
//
//                MealPlanDay::where(['meal_plan_group_id' => $mealPlanGroup->getKey(), 'date' => $date])->whereIn('recipe_id', $toDeleteIds)->delete();
//
//                $toAddIds = array_diff(Arr::pluck($items, 'id'), Arr::pluck($existing, 'recipe_id'));
//
//                foreach ($toAddIds as $toAddId) {
//                    MealPlanItem::create([
//                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
//                        'title' => $toAddId,
//                        'date' => $date,
//                    ]);
//                }
            }
        }

        $datesToDelete = array_diff(array_keys($existingItems), array_keys($schedule));

        MealPlanItem::whereIn('date', $datesToDelete)->where('meal_plan_group_id', $mealPlanGroup->getKey())->delete();
    }

    private function createName(array $dates): string {
        $firstDay = Carbon::parse(Arr::first($dates));
        $lastDay = Carbon::parse(Arr::last($dates));

        return vsprintf("%s - %s", [$firstDay->format('F d'), $lastDay->format('F d')]);
    }
}
