<?php

namespace Tests\Feature\ListFromMealPlanBuilder;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use App\Features\MealPlanToList\DateFilter;
use App\Features\MealPlanToList\ListFromMealPlanBuilder;
use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class ListFromMealPlanBuilderTest extends TestCase
{
	/** @test */
	public function it_adds_all_listable_meal_plan_items()
	{
		$recipeA = create(Recipe::class);
		$recipeA->listableIngredients()->save(make(ListableIngredient::class));

		$recipeB = create(Recipe::class);
		$recipeB->listableIngredients()->save(make(ListableIngredient::class));

		$recipeC = create(Recipe::class);
		$recipeC->listableIngredients()->save(make(ListableIngredient::class));

		$recipeA->linkedRecipes()->save($recipeC);

		$mealPlanGroup = create(MealPlanGroup::class, ['start_date' => Carbon::yesterday(), 'end_date' => Carbon::tomorrow()]);
		$mealPlanGroup->days()->save(make(MealPlanDay::class, ['recipe_id' => $recipeA->getKey(), 'date' => Carbon::now()]));
		$mealPlanGroup->days()->save(make(MealPlanDay::class, ['recipe_id' => $recipeB->getKey(), 'date' => Carbon::now()]));

		$mealPlanGroup->items()->save(make(MealPlanItem::class));
		$mealPlanGroup->items()->save(make(MealPlanItem::class, ['add_to_list' => false]));

		$groceryListCountBefore = GroceryList::count();

		$builder = new ListFromMealPlanBuilder($mealPlanGroup, new DateFilter($mealPlanGroup->start_date, $mealPlanGroup->end_date));

		$builder->buildList("pants");

		$this->assertEquals($groceryListCountBefore+1, GroceryList::count());

		$newList = GroceryList::get()->last();

		$this->assertCount(4, $newList->items);
	}
}
