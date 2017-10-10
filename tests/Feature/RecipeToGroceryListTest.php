<?php

namespace Tests\Feature;

use App\Entities\GroceryList;
use App\Entities\Recipe;
use App\Entities\RecipeItem;
use Tests\TestCase;

class RecipeToGroceryListTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_items_to_list()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $listableRecipe = factory(Recipe::class)->create();
        $recipeItem = factory(RecipeItem::class)->create(['listable' => 0]);
        $recipeItem2 = factory(RecipeItem::class)->create(['listable' => 1]);

        $listableRecipe->items()->saveMany([$recipeItem, $recipeItem2]);

        $grocerylist->addRecipe($listableRecipe);

        $this->assertCount(1, $grocerylist->items);
    }
}
