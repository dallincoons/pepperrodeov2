<?php

use Tests\TestCase;

class MealPlanListTest extends TestCase
{
    /** @test */
    public function it_updates_meal_plan_item_to_not_add_to_list()
    {
        $mealPlanItem = create(\App\MealPlanItem::class, [
            'add_to_list' => true,
        ]);

        $this->assertTrue($mealPlanItem->add_to_list);

        $this->patch('/api/v1/meal_plan_list_item/' . $mealPlanItem->getKey(), [
            'add_to_list' => false,
        ]);

        $this->assertEquals(0, $mealPlanItem->fresh()->add_to_list);
    }
}
