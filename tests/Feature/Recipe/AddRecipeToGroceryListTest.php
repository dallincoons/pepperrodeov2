<?php

namespace Tests\Feature;

use App\Entities\GroceryList;
use App\Entities\Ingredient;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class AddRecipeToGroceryListTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_items_to_list()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $listableRecipe = factory(Recipe::class)->create();
        $ingredient = factory(Ingredient::class)->create(['listable' => 0]);
        $ingredient2 = factory(Ingredient::class)->create(['listable' => 1]);

        $listableRecipe->ingredients()->saveMany([$ingredient, $ingredient2]);

        $grocerylist->addRecipe($listableRecipe);

        $this->assertCount(1, $grocerylist->items);
    }
}
