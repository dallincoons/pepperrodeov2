<?php

namespace Tests\Feature\Recipe;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

class AddsRecipeToGrocerylistTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_ingredients_to_list_via_http()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);

        $this->assertCount(0, $grocerylist->items);

        $response = $this->post($this->api('grocerylist/'. $grocerylist->getKey() .'/add-recipes'), [
            'recipes' => [$recipe->getKey()]
        ]);

        $response->assertSuccessful();
        $this->assertCount(count($recipe->listableIngredients), $grocerylist->fresh()->items);
    }

    /** @test */
    public function it_adds_multiple_recipes_to_a_grocery_list()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = $this->createRecipe();
        $recipe2 = $this->createRecipe();

        $this->assertCount(0, $grocerylist->items);

        $response = $this->post($this->api('grocerylist/'. $grocerylist->getKey() .'/add-recipes'), [
            'recipes' => [$recipe->getKey(), $recipe2->getKey()]
        ]);

        $ingredientCount = count($recipe->listableIngredients) + count($recipe2->listableIngredients);

        $response->assertSuccessful();
        $this->assertCount($ingredientCount, $grocerylist->fresh()->items);
    }

    protected function createRecipe()
    {
        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe->getKey()]);
        return $recipe;
    }
}
