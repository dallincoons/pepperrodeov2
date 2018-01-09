<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
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
}
