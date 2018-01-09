<?php

namespace Tests\Feature\Feature\GroceryLists;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

class CreatesGroceryListUsingRecipesTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_ingredients_to_list_with_api()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = $this->createRecipeWithIngredients();
        $recipe2 = $this->createRecipeWithIngredients();

        $this->assertCount(0, $grocerylist->items);

        $this->post($this->api("grocery-lists/{$grocerylist->getKey()}/add/recipes"), ['recipes' => [
            $recipe->getKey(), $recipe2->getKey()
        ]]);

        $this->assertCount(count($recipe->listableIngredients) + count($recipe->listableIngredients), $grocerylist->fresh()->items);
    }

    /**
     * @return Recipe
     */
    private function createRecipeWithIngredients(): Recipe
    {
        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        return $recipe;
    }
}
