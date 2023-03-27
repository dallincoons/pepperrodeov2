<?php

namespace Tests\Feature\MealPlanning;

use App\CategoryRecipe;
use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use Carbon\Carbon;
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
        $mealPlanGroup->days()->save(make(MealPlanDay::class, ['recipe_id' => $recipeA->getKey(), 'date' => $mealPlanGroup->start_date]));
        $mealPlanGroup->days()->save(make(MealPlanDay::class, ['recipe_id' => $recipeB->getKey(), 'date' => $mealPlanGroup->start_date]));

        $mealPlanGroup->items()->save(make(MealPlanItem::class));
        $mealPlanGroup->items()->save(make(MealPlanItem::class, ['add_to_list' => false]));

        $response = $this->post('/api/v1/meal_plan_list/' . $mealPlanGroup->getKey());

        $grocerylist = GroceryList::find($response->decodeResponseJson()['grocerylist']['id']);

        $this->assertCount(3, $grocerylist->items);
    }

    /** @test */
    public function it_creates_grocery_list_with_meal_plan_start_and_end_dates_by_default()
    {
        $recipeA = create(Recipe::class);
        $recipeA->listableIngredients()->save(make(ListableIngredient::class));

        $recipeB = create(Recipe::class);
        $recipeB->listableIngredients()->save(make(ListableIngredient::class));

        $mealPlanGroup = create(MealPlanGroup::class, ['start_date' => '2023-03-26', 'end_date' => '2023-03-30']);
        $mealPlanGroup->days()->save(make(MealPlanDay::class, ['recipe_id' => $recipeA->getKey()]));
        $mealPlanGroup->days()->save(make(MealPlanDay::class, ['recipe_id' => $recipeB->getKey()]));

        $mealPlanGroup->items()->save(make(MealPlanItem::class));
        $mealPlanGroup->items()->save(make(MealPlanItem::class, ['add_to_list' => false]));

        $response = $this->post('/api/v1/meal_plan_list/' . $mealPlanGroup->getKey());

        $grocerylist = GroceryList::find($response->decodeResponseJson()['grocerylist']['id']);

        $this->assertEquals('2023-03-26', $grocerylist->start_date);
        $this->assertEquals('2023-03-30', $grocerylist->end_date);
    }
}
