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
        ]);

        $response->assertSuccessful();
        $this->assertEquals(1, Recipe::count());

        $recipe = Recipe::first();

        $this->assertEquals('foo bar', $recipe->title);
        $this->assertEquals('cook things', $recipe->directions);
        $this->assertEquals('15 minute hours', $recipe->prep_time);
        $this->assertEquals('26 seconds plus 1 day', $recipe->total_time);
        $this->assertEquals('ur mom', $recipe->serves);
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
                    'quantity'    => 2,
                    'description' => 'jazz music',
                ]
            ],
            'listable_ingredients' => [
                [
                    'quantity'    => 3,
                    'description' => 'jazz music2',
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
                    'description' => 'jazz music',
                ]
            ],
            'listable_ingredients' => [
                [
                    'quantity'    => 3,
                    'description' => 'jazz music2',
                    'department_id' => 2
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertArraySubset([
            'department_id' => $department->getKey(),
        ], Recipe::first()->listableIngredients->first()->toArray());
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
