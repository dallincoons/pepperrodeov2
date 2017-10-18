<?php

namespace Tests\Feature\Recipe;

use App\Entities\Recipe;
use App\Entities\RecipeItem;
use Tests\Fakers\RecipeFaker;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class RetrievesRecipeTest extends TestCase
{
    /** @test */
    public function it_retrieves_all_recipes()
    {
        $recipes = factory(Recipe::class, 2)->create();
        $recipes->first()->items()->save(factory(RecipeItem::class)->make());

        $response = $this->get($this->api('recipes'));

        $response->assertSuccessful();
        $this->assertCount(2, $response->decodeResponseJson());
    }

    /** @test */
    public function it_retrieves_a_single_recipe_with_items()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->get($this->api('recipes/' . $recipe->getKey()));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertArrayHasKey('items', $responseRecipe);
    }
}
