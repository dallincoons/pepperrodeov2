<?php

namespace Tests\Feature\MealPlanning;

use App\MealPlanDay;
use App\MealPlanGroup;
use Tests\TestCase;

class MealPlanListTest extends TestCase
{
    /** @test */
    public function it_converts_meal_plan_to_grocery_list()
    {
        $mealPlanGroup = create(MealPlanGroup::class);
        $mealPlanGroup->days()->save(make(MealPlanDay::class));
        $mealPlanGroup->days()->save(make(MealPlanDay::class));
        $mealPlanGroup->days()->save(make(MealPlanDay::class));

        $this->post('/api/v1/meal_plan_list/' . $mealPlanGroup->getKey());
    }
}
