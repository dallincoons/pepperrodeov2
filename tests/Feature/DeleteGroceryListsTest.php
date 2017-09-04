<?php

namespace Tests\Feature;

use App\Entities\GroceryList;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group delete-grocery-lists-tests
 */
class DeleteGroceryListsTest extends TestCase
{
    /** @test */
    public function it_deletes_a_grocery_list()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $response = $this->post('/api/v1/grocery-list/' . $grocerylist->getKey());

        $response->assertStatus(200);
        $this->assertNull($grocerylist->fresh());
    }
}
