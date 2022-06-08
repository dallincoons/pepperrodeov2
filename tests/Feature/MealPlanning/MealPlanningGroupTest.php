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

        $schedule = $response->decodeResponseJson()['schedule'];

        $this->assertCount(2, $schedule['2020-01-01']['recipes']);
        $this->assertCount(1, $schedule['2020-01-02']['recipes']);
        $this->assertCount(1, $schedule['2020-01-01']['items']);
        $this->assertCount(2, $schedule['2020-01-02']['items']);
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
                'items' => [[
                    'id' => -1,
                    'title' => 'push broom',
                ]]
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
        $this->assertArrayHasKey('schedule', $responseData);
        $schedule = $responseData['schedule'];
        $this->assertCount(3, $schedule);
        $this->assertCount(2, $schedule['2020-01-03']);
    }

    /** @test */
    public function it_updates_meal_plan_groupabc()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $recipeA = create(Recipe::class);
        $recipeB = create(Recipe::class);
        $recipeC = create(Recipe::class);

        $day1 = create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-23']);
        $day2 = create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-24']);
        $day3 = create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeB, 'date' => '2021-01-24']);

        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA, 'date' => '2021-01-26']);

        $scheduled = [
            '2021-01-22' => [],
            '2021-01-23' => [
            'recipes' => [[
                'id' => $recipeA->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ]
            ]],
            '2021-01-24' => [
            'recipes' => [
            [
                'id' => $recipeA->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ],
            [
                'id' => $recipeC->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ]
            ]],
            '2021-01-25' => [
            'recipes' => [[
                'id' => $recipeB->getKey(),
                'parent_id' => null,
                "user_id" => 1,
            ]]
            ],
        ];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'schedule' => $scheduled,
        ]);

        $responseData = $response->decodeResponseJson();

        $recipes  = $mealPlanGroup->fresh()->recipes;

        $this->assertCount(4, $recipes);
        $this->assertCount(1, $recipes->where('date', '2021-01-23'));
        $this->assertCount(2, $recipes->where('date', '2021-01-24'));
        $this->assertCount(1, $recipes->where('date', '2021-01-25'));
    }/** @test */

    /** @test */
    public function it_updates_meal_plan_group_with_new_items_on_new_day()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(0, $items);

        $schedule = [
            '2021-01-23' => [
                'recipes' => [],
                'items' => [[
                    'id' => -1,
                    'title' => 'push broom',
                ]]
            ],
            '2021-01-25' => ['recipes' => [], 'items' => []],
        ];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'schedule' => $schedule
        ]);

        $items = $mealPlanGroup->fresh()->items;

        $response->decodeResponseJson();
        $this->assertCount(1, $items);
    }

    /** @test */
    public function it_updates_meal_plan_group_with_new_items_on_existing_day()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $itemA = create(MealPlanItem::class, ['date' => '2020-01-01', 'meal_plan_group_id' => $mealPlanGroup->getKey()]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(1, $items);

        $schedule = [
            '2020-01-01' => [
                'recipes' => [],
                'items' => [[
                    'id' => -1,
                    'title' => 'push broom'
                ], [
                    'id' => $itemA->getKey(),
                ]]
            ],
            '2021-01-25' => ['recipes' => [], 'items' => []],
        ];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'schedule' => $schedule
        ]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(2, $items);
    }

    /** @test */
    public function it_updates_meal_plan_group_with_new_adhoc_items()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(0, $items);

        $schedule = [
            '2020-01-01' => [
                'recipes' => [],
                'items' => [],
            ],
            '2021-01-25' => ['recipes' => [], 'items' => []],
        ];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'schedule' => $schedule,
            'extraItems' => [[
                'id' => -1,
                'title' => 'push broom'
            ], [
                'id' => -1,
                'title' => 'squatweiler',
            ]],
        ]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(2, $items);
    }

    /** @test */
    public function it_deletes_meal_plan_items()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $itemA = create(MealPlanItem::class, ['date' => '2020-01-01', 'meal_plan_group_id' => $mealPlanGroup->getKey()]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(1, $items);

        $schedule = [
            '2020-01-01' => [
                'recipes' => [],
                'items' => []
            ],
            '2021-01-25' => [
                'recipes' => [],
                'items' => []
            ],
        ];

        $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'schedule' => $schedule
        ]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(0, $items);
    }


    /** @test */
    public function it_deletes_meal_plan_ad_hoc_items()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $itemA = create(MealPlanItem::class, ['date' => null, 'meal_plan_group_id' => $mealPlanGroup->getKey()]);
        $itemB = create(MealPlanItem::class, ['date' => null, 'meal_plan_group_id' => $mealPlanGroup->getKey()]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(2, $items);

        $schedule = [
            '2020-01-01' => [
                'recipes' => [],
                'items' => [],
            ],
            '2021-01-25' => ['recipes' => [], 'items' => []],
        ];

        $response = $this->patch('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey(), [
            'schedule' => $schedule,
            'extraItems' => [[
                'id' => $itemB->getKey(),
            ]],
        ]);

        $items = $mealPlanGroup->fresh()->items;

        $this->assertCount(1, $items);
        $this->assertEquals($items[0]['id'], $itemB->getKey());
    }
}
