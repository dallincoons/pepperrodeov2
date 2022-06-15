<?php

namespace Tests\Feature\MealPlanning;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use Tests\TestCase;

class MealPlanListTest extends TestCase
{
    /** @test */
    public function it_converts_meal_plan_to_grocery_list()
    {
        $recipeA = create(Recipe::class);
        $recipeA->listableIngredients()->save(make(ListableIngredient::class));

        $recipeB = create(Recipe::class);
        $recipeB->listableIngredients()->save(make(ListableIngredient::class));

        $mealPlanGroup = create(MealPlanGroup::class);
        $mealPlanGroup->recipes()->save(make(MealPlanDay::class, ['recipe_id' => $recipeA->getKey()]));
        $mealPlanGroup->recipes()->save(make(MealPlanDay::class, ['recipe_id' => $recipeB->getKey()]));

        $mealPlanGroup->items()->save(make(MealPlanItem::class));
        $mealPlanGroup->items()->save(make(MealPlanItem::class, ['add_to_list' => false]));

        $this->post('/api/v1/meal_plan_list/' . $mealPlanGroup->getKey());

        $grocerylist = GroceryList::all()->last();

        $this->assertCount(3, $grocerylist->items);
    }
}
