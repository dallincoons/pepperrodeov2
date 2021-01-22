<?php

namespace Tests\Feature\MealPlanning;

use App\Entities\Recipe;
use App\MealPlanDay;
use App\MealPlanGroup;
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
    public function it_stores_a_new_meal_planning_group()
    {
        $rawJson = '{"2021-01-20":[],"2021-01-21":[],"2021-01-22":[],"2021-01-23":[],"2021-01-24":[{"id":157,"parent_id":null,"title":"Whipped Cream","directions":"Place a metal mixing bowl and metal whisk into the freezer for 10 to 15 minutes.\n\nPlace the sugar into the mixing bowl and add the whipping cream. \n\nWhisk just until the cream reaches stiff peaks. \n\nStore any unused portion in an airtight container for up to 10 hours. \n\nWhen ready to use, rewhisk for 10 to 15 seconds.","user_id":1,"category_id":7,"created_at":"2019-10-27 23:45:31","updated_at":"2020-10-04 22:55:58","prep_time":"10 mins","total_time":"15 mins","serves":"a few","deleted_at":null,"source":null,"source_type":null,"category":{"id":7,"user_id":1,"title":"Dessert","created_at":"2020-10-04 22:17:08","updated_at":"2020-10-04 22:17:08"}},{"id":317,"parent_id":null,"title":"Mango Pops","directions":"1. Combine in food processor\n2. Pour into molds and freeze for at least 6 hours","user_id":1,"category_id":7,"created_at":"2020-10-13 16:40:06","updated_at":"2020-10-13 16:40:06","prep_time":"","total_time":"","serves":"","deleted_at":null,"source":null,"source_type":null,"category":{"id":7,"user_id":1,"title":"Dessert","created_at":"2020-10-04 22:17:08","updated_at":"2020-10-04 22:17:08"}}],"2021-01-25":[{"id":314,"parent_id":null,"title":"Strawberry Ice Pops","directions":"1. Combine all ingredients in food processor\n2. Pour into ice molds and freeze for at least 4 hours","user_id":1,"category_id":7,"created_at":"2020-10-13 16:36:14","updated_at":"2020-10-13 16:36:14","prep_time":"","total_time":"","serves":"","deleted_at":null,"source":null,"source_type":null,"category":{"id":7,"user_id":1,"title":"Dessert","created_at":"2020-10-04 22:17:08","updated_at":"2020-10-04 22:17:08"}}],"2021-01-26":[],"2021-01-27":[]}';

        $this->post('/api/v1/meal_planning_groups', ['scheduled_recipes' => json_decode($rawJson, true)]);

        $mealPlanningGroups = MealPlanGroup::all();

        $this->assertCount(1, $mealPlanningGroups);
        $this->assertEquals('Grocery List for January 24 - January 25', $mealPlanningGroups->first()->name);
        $this->assertCount(3, MealPlanDay::all());
    }

    /** @test */
    public function it_gets_single_meal_plan_group_with_meal_plan_days()
    {
        $mealPlanGroup = create(MealPlanGroup::class);

        $recipeA = create(Recipe::class);
        $recipeB = create(Recipe::class);

        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA]);
        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeA]);
        create(MealPlanDay::class, ['meal_plan_group_id' => $mealPlanGroup->getKey(), 'recipe_id' => $recipeB]);

        $response = $this->get('/api/v1/meal_planning_group/' . $mealPlanGroup->getKey());

        $responseData = $response->decodeResponseJson();
        $this->assertEquals($mealPlanGroup->getKey(), $responseData['group']['id']);
        $this->assertCount(3, $responseData['group']['days']);
        $this->assertCount(2, $responseData['recipes']);
    }
}
