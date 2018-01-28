<?php

namespace Tests\Feature;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class AddRecipeToGroceryListTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_ingredients_to_list()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);

        $this->assertCount(0, $grocerylist->items);

        $grocerylist->addRecipe($recipe);

        $this->assertCount(count($recipe->listableIngredients), $grocerylist->fresh()->items);
    }

    /** @test */
    public function it_adds_the_same_recipe_to_list_again()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);

        $this->assertCount(0, $grocerylist->items);

        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe);

        $this->assertCount(count($recipe->listableIngredients) * 2, $grocerylist->fresh()->items);
    }
}
