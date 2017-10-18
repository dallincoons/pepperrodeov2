<?php

namespace Tests\Feature\Recipe;

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
        $response = $this->createRecipe();

        $response->assertSuccessful();
        $this->assertEquals(1, Recipe::count());
    }

    /** @test */
    public function it_creates_a_recipe_with_items()
    {
        $response = $this->createRecipe([
            'items' => [
                [
                    'quantity'    => 2,
                    'description' => 'jazz music',
                    'listable'    => 1
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Recipe::count());
        $this->assertArraySubset([
            'quantity'    => 2,
            'description' => 'jazz music',
            'listable'    => 1
        ], Recipe::first()->items->first()->toArray());
    }

    private function createRecipe($overrides = [])
    {
        return $this->post($this->api('recipes/create'), $this->validParams($overrides));
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Twelve Squishy Soup',
        ], $overrides);
    }
}
