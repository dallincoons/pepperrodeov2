<?php

namespace Tests\Feature\Recipe;

use App\Entities\Ingredient;
use App\Entities\Recipe;
use App\User;
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
        $recipes = factory(Recipe::class, 2)->create(['user_id' => $this->user->getKey()]);
        factory(Recipe::class)->create(['user_id' => factory(User::class)->create()]);

        $recipes->first()->ingredients()->save(factory(Ingredient::class)->make());

        $response = $this->get($this->api('recipes'));

        $response->assertSuccessful();
        $this->assertCount(2, $response->decodeResponseJson());
    }

    /** @test */
    public function it_retrieves_a_single_recipe_with_ingredients()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->get($this->api('recipes/' . $recipe->getKey()));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertArrayHasKey('ingredients', $responseRecipe);
    }
}
