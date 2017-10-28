<?php

namespace Tests\Feature\Recipe;

use App\Entities\Ingredient;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class CreatesRecipesTest extends TestCase
{
    /** @test */
    public function it_creates_a_recipe_without_items()
    {
        $response = $this->createRecipe([
            'title' => 'foo bar',
            'directions' => 'cook things'
        ]);

        $response->assertSuccessful();
        $this->assertEquals(1, Recipe::count());

        $recipe = Recipe::first();

        $this->assertEquals('foo bar', $recipe->title);
        $this->assertEquals('cook things', $recipe->directions);
    }

    /** @test */
    public function it_creates_a_recipe_with_ingredients()
    {
        $response = $this->createRecipe([
            'ingredients' => [
                [
                    'quantity'    => 2,
                    'description' => 'jazz music',
                    'listable'    => 1
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Ingredient::count());
        $this->assertArraySubset([
            'quantity'    => 2,
            'description' => 'jazz music',
            'listable'    => 1
        ], Recipe::first()->ingredients->first()->toArray());
    }

    private function createRecipe($overrides = [])
    {
        return $this->post($this->api('recipes/create'), $this->validParams($overrides));
    }

    private function validParams($overrides = [])
    {
        return array_merge(factory(Recipe::class)->raw(), $overrides);
    }
}
