<?php

namespace Tests\Feature\GroceryListItems;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\Fakers\RecipeFaker;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class RetrievesGroceryListItemsTest extends TestCase
{
    /** @test */
    public function it_combines_grocery_list_items()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();
        $recipe = RecipeFaker::withListableItems([
            [
                'description' => 'test123',
                'quantity'    => '1/3',
            ],
            [
                'description' => 'test123',
                'quantity'    => '1/3',
            ],
            [
                'description' => '456',
                'quantity'    => '1 1/6',
            ],
            [
                'description' => '456',
                'quantity'    => '3/4',
            ],
            [
                'description' => '789',
                'quantity'    => '3/4',
            ],
        ]);

        $grocerylist->addRecipe($recipe);

        $items = $grocerylist->getCombinedItems();

        $result = $items->pluck('quantity');

        $this->assertCount(3, $items);
        $this->assertContains('1 11/12', $result);
        $this->assertContains('2/3', $result);
        $this->assertContains('3/4', $result);
    }

    /** @test */
    public function it_combines_grocery_list_items_with_null_quantities()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();
        $recipe = factory(Recipe::class)->create();
        $recipe2 = factory(Recipe::class)->create();
        $ingredient = factory(ListableIngredient::class)->create(['recipe_id' => $recipe, 'description' => 'same']);
        $ingredient2 = factory(ListableIngredient::class)->create(['recipe_id' => $recipe2, 'description' => 'same']);
        $ingredient->setRawAttributes(['quantity' => null])->save();
        $ingredient2->setRawAttributes(['quantity' => null])->save();

        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe2);

        $items = $grocerylist->getCombinedItems();

        $this->assertCount(1, $items);
    }
}
