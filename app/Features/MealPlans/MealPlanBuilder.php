<?php

namespace App\Features\MealPlans;

use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class MealPlanBuilder
{
    public function create(array $schedule, array $extraItems = [])
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
                    'title' => $item['title'],
                    'date' => $date,
                ]);
            }

            foreach ($extraItems as $item) {
                MealPlanItem::create([
                    'meal_plan_group_id' => $mealPlanningGroup->getKey(),
                    'title' => $item['title'],
                    'add_to_list' => $item['addToList'] ?? true,
                ]);
            }
        }

        return $mealPlanningGroup;
    }

    public function update(MealPlanGroup $mealPlanGroup, array $schedule, array $adHocItems)
    {
        $existingRecipes = $mealPlanGroup->recipes->groupBy('date')->all();
        $existingItems = $mealPlanGroup->items()->whereNotNull('date')->get()->groupBy('date')->all();
        $existingAdHocItems = $mealPlanGroup->items()->whereNull('date')->get()->all();

        foreach ($schedule as $date => $scheduled) {
            if (!array_key_exists('recipes', $scheduled)) {
                continue;
            }
            $recipes = $scheduled['recipes'];
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

        $this->syncItems($existingItems, $schedule, $mealPlanGroup);
        $this->syncAdHocItems($existingAdHocItems, $adHocItems, $mealPlanGroup);
    }

    private function syncItems($existingItems, $schedule, MealPlanGroup $mealPlanGroup) {
        foreach ($schedule as $date => $scheduled) {
            if (!array_key_exists('items', $scheduled)) {
                continue;
            }
            $items = $scheduled['items'];

            if (!array_key_exists($date, $existingItems)) {
                foreach ($items as $item) {
                    if (!array_key_exists('title', $item)) {
                        continue;
                    }

                    MealPlanItem::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'title' => $item['title'],
                        'date' => $date,
                        'add_to_list' => $newItem['addToList'] ?? false,
                    ]);
                }
            } else {
                $existing = $existingItems[$date];

                $toDeleteIds = array_diff(Arr::pluck($existing, 'id'), Arr::pluck($items, 'id'));

                MealPlanItem::where(['meal_plan_group_id' => $mealPlanGroup->getKey(), 'date' => $date])->whereIn('id', $toDeleteIds)->delete();

                $toAdds = collect($items)->where('id', -1)->toArray();

                foreach ($toAdds as $toAdd) {
                    MealPlanItem::create([
                        'meal_plan_group_id' => $mealPlanGroup->getKey(),
                        'title' => $toAdd['title'],
                        'date' => $date,
                        'add_to_list' => $newItem['addToList'] ?? false,
                    ]);
                }
            }
        }

        $datesToDelete = array_diff(array_keys($existingItems), array_keys($schedule));

        MealPlanItem::whereIn('date', $datesToDelete)->where('meal_plan_group_id', $mealPlanGroup->getKey())->delete();
    }

    private function syncAdHocItems($existingItems, $newItems, MealPlanGroup $mealPlanGroup) {
        foreach ($newItems as $newItem) {
            if (!is_array($newItem)) {
                continue;
            }
            if (!array_key_exists('id', $newItem) || !array_key_exists('title', $newItem)) {
                continue;
            }

            if ($newItem['id'] < 0) {
                MealPlanItem::create([
                    'meal_plan_group_id' => $mealPlanGroup->getKey(),
                    'title' => $newItem['title'],
                    'add_to_list' => $newItem['addToList'] ?? true,
                ]);
            }
        }

        $newItemIDs = collect($newItems)->pluck('id')->all();

        $itemIDsToDelete = array_diff(collect($existingItems)->pluck('id')->all(), $newItemIDs);

        MealPlanItem::whereIn('id', $itemIDsToDelete)->where('meal_plan_group_id', $mealPlanGroup->getKey())->delete();
    }

    private function createName(array $dates): string {
        $firstDay = Carbon::parse(Arr::first($dates));
        $lastDay = Carbon::parse(Arr::last($dates));

        return vsprintf("%s - %s", [$firstDay->format('F d'), $lastDay->format('F d')]);
    }
}
