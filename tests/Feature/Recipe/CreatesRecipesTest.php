<?php

namespace Tests\Feature\Recipe;

use App\Recipe;
use Tests\TestCase;

class CreatesRecipesTest extends TestCase
{
    /** @test */
    public function it_creates_a_recipe_without_items()
    {
        $response = $this->createRecipe();

        $response->assertSuccessful();
        $this->assertEquals(1, Recipe::count());
    }

    private function createRecipe($overrides = [])
    {
        return $this->post($this->api('recipe/create'), $this->validParams($overrides));
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Twelve Squishy Soup',
        ], $overrides);
    }
}
