<?php

namespace Tests\Feature\Recipe;

use App\Entities\Ingredient;
use App\Entities\Recipe;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
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
    public function it_ignores_sub_recipes_when_getting_recipe_list()
    {
        $recipe = create(Recipe::class);
        $subRecipe = create(Recipe::class, ['parent_id' => $recipe->getKey()]);

        $response = $this->get($this->api('recipes'));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertCount(1, $responseRecipe);
    }

    /** @test */
    public function it_retrieves_a_single_recipe_with_ingredients()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->get($this->api('recipes/' . $recipe->getKey()));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertArrayHasKey('recipe', $responseRecipe);
        $this->assertArrayHasKey('ingredients', $responseRecipe['recipe']);
    }

    /** @test */
    public function ingredients_have_departments_loaded()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->get($this->api('recipes/' . $recipe->getKey()));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertIsArray(Arr::get($responseRecipe, 'recipe.ingredients.0.department'));
    }

    /** @test */
    public function it_retrieves_a_single_recipe_with_listable_ingredients()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->get($this->api('recipes/' . $recipe->getKey()));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertArrayHasKey('recipe', $responseRecipe);
        $this->assertArrayHasKey('listable_ingredients', $responseRecipe['recipe']);
    }

    /** @test */
    public function it_retrieves_a_single_recipe_with_a_category()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->get($this->api('recipes/' . $recipe->getKey()));

        $responseRecipe = $response->decodeResponseJson();

        $response->assertSuccessful();
        $this->assertArrayHasKey('recipe', $responseRecipe);
        $this->assertArrayHasKey('category', $responseRecipe['recipe']);
    }

    /**
     * @test
     */
    public function get_deleted_recipes()
    {
        create(Recipe::class, [
            'deleted_at' => Carbon::now(),
        ]);

        $response = $this->get($this->api('deleted_recipes'));

        $recipe = $response->decodeResponseJson();

        $this->assertCount(1, $recipe);
    }
}
