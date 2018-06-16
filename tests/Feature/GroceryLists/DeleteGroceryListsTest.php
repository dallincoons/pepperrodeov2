<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Entities\GroceryListItemGroup;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group delete-grocery-lists-tests
 * @group feature-tests
 */
class DeleteGroceryListsTest extends TestCase
{
    /** @test */
    public function it_deletes_a_grocery_list()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $response = $this->delete('/api/v1/grocery-lists/' . $grocerylist->getKey());

        $response->assertStatus(200);
        $this->assertNull($grocerylist->fresh());
    }

    /** @test */
    public function it_deletes_a_grocery_list_with_grocery_list_item_group()
    {
        $grocerylist = factory(GroceryList::class)->create();
        $recipe = factory(Recipe::class)->create();

        $group = factory(GroceryListItemGroup::class)->create([
            'recipe_id' => $recipe->getKey(),
            'grocery_list_id' => $grocerylist->getKey()
        ]);

        factory(GroceryListItem::class)->create([
            'grocery_list_group_id' => $group->getKey()
        ]);

        $response = $this->delete('/api/v1/grocery-lists/' . $grocerylist->getKey());

        $response->assertStatus(200);
        $this->assertNull($grocerylist->fresh());
    }
}
