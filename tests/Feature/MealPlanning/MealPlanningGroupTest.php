<?php

namespace Tests\Feature\MealPlanning;

use App\Entities\Recipe;
use App\MealPlanDay;
use App\MealPlanGroup;
use App\MealPlanItem;
use Tests\TestCase;

class MealPlanningGroupTest extends TestCase
{
    /** @test */
    public function get_all_meal_planning_group()
    {
        create(MealPlanGroup::class);

        $response = $this->get('/api/v1/meal_planning_groups');

        $this->assertCount(1, $response->decodeResponseJson());
    }

    /** @test */
    public function get_one_meal_planning_group()
    {
        $recipe = create(Recipe::class);

        $group = create(MealPlanGroup::class);
        create(MealPlanDay::class, ['meal_plan_group_id' => $group->getKey(), 'recipe_id' => $recipe, 'date' => '2020-01-01']);
        create(MealPlanDay::class, ['meal_plan_group_id' => $group->getKey(), 'recipe_id' => $recipe, 'date' => '2020-01-01']);
        create(MealPlanDay::class, ['meal_plan_group_id' => $group->getKey(), 'recipe_id' => $recipe, 'date' => '2020-01-02']);
        create(MealPlanItem::class, ['meal_plan_group_id' => $group->getKey(), 'date' => '2020-01-01']);
        create(MealPlanItem::class, ['meal_plan_group_id' => $group->getKey(), 'date' => '2020-01-02']);
        create(MealPlanItem::class, ['meal_plan_group_id' => $group->getKey(), 'date' => '2020-01-02']);

        $response = $this->get('/api/v1/meal_planning_group/' . $group->getKey());

        $this->assertCount(2, $response->decodeResponseJson()['2020-01-01']['recipes']);
        $this->assertCount(1, $response->decodeResponseJson()['2020-01-02']['recipes']);
        $this->assertCount(1, $response->decodeResponseJson()['2020-01-01']['items']);
        $this->assertCount(2, $response->decodeResponseJson()['2020-01-02']['items']);
    }

    /** @test */
    public function it_stores_a_new_meal_planning_group()
    {
        $schedule = [
            '2021-01-20' => [],
            '2021-01-21' => [],
            '2021-01-22' => [],
            '2021-01-23' => [
                'recipes' => [[
                    'id' => 157,
                    'parent_id' => null,
                    'title' => 'Whipped Cream',
                    'directions' => 'use a metal spatula'
                ]],
                'items' => [
                    'push broom'
                ]
            ],
            '2021-01-24' => [
                'recipes' => [[
                    'id' => 315,
                    'parent_id' => null,
                    'title' => 'Strawberry Iced pop',
                    'directions' => 'use a metal spatula'
                ]],
                'item' => [],
            ],
            '2021-01-25' => [],
        ];

        $this->post('/api/v1/meal_planning_groups', ['schedule' => $schedule]);

        $mealPlanningGroups = MealPlanGroup::all();

        $this->assertCount(1, $mealPlanningGroups);
        $this->assertEquals('January 20 - January 25', $mealPlanningGroups->first()->name);
        $this->assertCount(2, MealPlanDay::all());
    }

    /** @test */
    public function it_deletes_a_meal_planning_group()
    {
        $plan = create(MealPlanGroup::class);

        $this->assertCount(1, MealPlanGroup::all());

        $this->delete('/api/v1/meal_planning_group/' . $plan->getKey());

        $this->assertCount(0, MealPlanGroup::all());
    }

    /** @test */
    public function it_update_a_meal_planning_group()
    {
        $plan = create(MealPlanGroup::class);

        $response = $this->patch('/api/v1/meal_planning_group/' . $plan->getKey());

        $response->assertOk();
    }

    /** @test */
    public function it_gets_single_meal_plan_group_with_meal_plan_days()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $recipeA = create(Recipe::class);
        $recipeB = create(Recipe::class);

        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2020-01-01']);
        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2020-01-02']);
        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeB, 'date' => '2020-01-03']);
        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeB, 'date' => '2020-01-03']);

        $response = $this->get('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey());

        $responseData = $response->decodeResponseJson();
        $this->assertCount(3, $responseData);
        $this->assertCount(2, $responseData['2020-01-03']);
    }

    /** @test */
    public function it_updates_meal_plan_group()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $recipeA = create(Recipe::class);
        $recipeB = create(Recipe::class);
        $recipeC = create(Recipe::class);

        $day1 = create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-23']);
        $day1 = create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-24']);
        $day2 = create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeB, 'date' => '2021-01-24']);

        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-26']);

        $days = [
            '2021-01-22' => [],
            '2021-01-23' => [[
                'id' => $recipeA->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ]],
            '2021-01-24' => [[
                'id' => $recipeA->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ],
            [
                'id' => $recipeC->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ]],
            '2021-01-25' => [[
                'id' => $recipeB->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ]],
        ];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'scheduled_recipes' => $days
        ]);

        $days = $mealPlanGroup->fresh()->days;

        $responseData = $response->decodeResponseJson();
        $this->assertCount(4, $days);
        $this->assertCount(1, $days->where('date', '2021-01-23'));
        $this->assertCount(2, $days->where('date', '2021-01-24'));
        $this->assertCount(1, $days->where('date', '2021-01-25'));
    }/** @test */

    /** @test */
    public function it_updates_meal_plan_group_without_deleting_any_days()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $recipeA = create(Recipe::class);

        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-26']);

        $days = [];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'scheduled_recipes' => $days
        ]);

        $days = $mealPlanGroup->fresh()->days;

        $responseData = $response->decodeResponseJson();
        $this->assertCount(0, $days);
    }
}
