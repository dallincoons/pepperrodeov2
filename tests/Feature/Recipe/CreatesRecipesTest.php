<?php

namespace Tests\Feature\Recipe;

use App\Category;
use App\Entities\Department;
use App\Entities\Ingredient;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group feature-tests
 * @group recipe-tests
 * @group creates-recipes-tests
 */
class CreatesRecipesTest extends TestCase
{
    /** @test */
    public function it_creates_a_recipe_without_ingredients()
    {
        $response = $this->createRecipe([
            'title'      => 'foo bar',
            'directions' => 'cook things',
            'prep_time'  => '15 minute hours',
            'total_time'  => '26 seconds plus 1 day',
            'serves'      => 'ur mom',
            'source'      => 'http://ilikecake.net'
        ]);

        $response->assertSuccessful();
        $this->assertEquals(1, Recipe::count());

        $recipe = Recipe::first();

        $this->assertEquals('foo bar', $recipe->title);
        $this->assertEquals('cook things', $recipe->directions);
        $this->assertEquals('15 minute hours', $recipe->prep_time);
        $this->assertEquals('26 seconds plus 1 day', $recipe->total_time);
        $this->assertEquals('ur mom', $recipe->serves);
        $this->assertEquals('http://ilikecake.net', $recipe->source);
        $this->assertEquals(Recipe::SOURCE_TYPE_URL, $recipe->source_type);
    }

    /** @test */
    public function it_creates_a_recipe_with_ingredients()
    {
        $response = $this->createRecipe([
            'title'       => 'foo bar',
            'directions'  => 'cook things',
            'category_id'    => factory(Category::class)->create()->getKey(),
            'ingredients' => [
                [
                    'full_description' => '2 jazz music',
                ]
            ],
            'listable_ingredients' => [
                [
                    'full_description' => '3 jazz music2',
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Ingredient::count());
        $this->assertEquals(1, ListableIngredient::count());
        $this->assertArraySubset([
            'quantity'    => 2,
            'description' => 'jazz music',
        ], Recipe::first()->ingredients->first()->toArray());
        $this->assertArraySubset([
            'quantity'    => 3,
            'description' => 'jazz music2',
        ], Recipe::first()->listableIngredients->first()->toArray());
    }

    /** @test */
    public function it_creates_a_recipe_with_departmentalized_ingredients()
    {
        $department = factory(Department::class)->create();

        $response = $this->createRecipe([
            'title'       => 'foo bar',
            'directions'  => 'cook things',
            'category_id'    => factory(Category::class)->create()->getKey(),
            'ingredients' => [
                [
                    'quantity'    => 2,
                    'full_description' => 'jazz music',
                ]
            ],
            'listable_ingredients' => [
                [
                    'quantity'    => 3,
                    'full_description' => 'jazz music2',
                    'department_id' => 2
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertArraySubset([
            'department_id' => $department->getKey(),
        ], Recipe::first()->listableIngredients->first()->toArray());
    }

    /**
     * @covers \App\Http\Controllers\RecipeController::store
     *
     * @test
     */
    public function it_creates_a_recipe_with_sub_recipes()
    {
        $department = factory(Department::class)->create();

        $response = $this->createRecipe([
            'title'       => 'foo bar',
            'category_id'    => factory(Category::class)->create()->getKey(),
            'sub_recipes' => [[
                'title'       => 'foo bar',
                'directions'  => 'cook things',
                'ingredients' => [
                    [
                        'quantity'    => 2,
                        'full_description' => 'jazz music',
                    ]
                ],
                'listable_ingredients' => [
                    [
                        'quantity'    => 3,
                        'full_description' => 'jazz music2',
                        'department_id' => 2
                    ]
                ]
            ],
            [
                'title'       => 'biz baz',
                'directions'  => 'do things to the food',
                'ingredients' => [
                    [
                        'quantity'    => 2,
                        'full_description' => 'cambodia',
                    ]
                ],
                'listable_ingredients' => [
                    [
                        'quantity'    => 1,
                        'full_description' => 'shadazz',
                    ]
                ]
            ]]
        ]);

        $this->assertEquals(3, Recipe::count());
    }

    private function createRecipe($overrides = [])
    {
        return $this->post($this->api('recipes'), $this->validParams($overrides));
    }

    private function validParams($overrides = [])
    {
        return array_merge(factory(Recipe::class)->raw(), $overrides);
    }
}
