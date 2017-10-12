<?php

namespace Tests\Feature\GroceryListItems;

use App\Entities\GroceryList;
use Tests\Fakers\RecipeFaker;
use Tests\TestCase;

class RetrievesGroceryListItemsTest extends TestCase
{
    /** @test */
    public function it_gets_combined_grocery_list_items()
    {
        $grocerylist = factory(GroceryList::class)->create();
        $recipe = RecipeFaker::withItems([
            [
                'description' => 'test123',
                'quantity'    => '1/3',
                'listable'    => 1
            ],
            [
                'description' => 'test123',
                'quantity'    => '1/3',
                'listable'    => 1
            ],
            [
                'description' => '456',
                'quantity'    => '1 1/6',
                'listable'    => 1
            ],
            [
                'description' => '456',
                'quantity'    => '3/4',
                'listable'    => 1
            ],
            [
                'description' => '789',
                'quantity'    => '3/4',
                'listable'    => 1
            ],
        ]);

        $grocerylist->addRecipe($recipe);

        $items = $grocerylist->combinedItems();

        $result = $items->pluck('quantity');

        $this->assertCount(3, $items);
        $this->assertContains('1 11/12', $result);
        $this->assertContains('2/3', $result);
        $this->assertContains('3/4', $result);
    }
}
