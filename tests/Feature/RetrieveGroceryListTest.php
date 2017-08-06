<?php

namespace Tests\Feature;

use App\GroceryList;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group retrieve-grocery-lists-tests
 */
class RetrieveGroceryListTest extends TestCase
{
    /** @test */
    public function it_gets_all_grocery_lists()
    {
        $grocerylists = factory(GroceryList::class, 2)->create();

        $response = $this->get('/api/v1/grocery-lists');
        $contents = $response->decodeResponseJson();

        $response->assertStatus(200);
        $this->assertCount(2, $contents);
        $this->assertEquals($grocerylists->pluck('id'), collect($response->decodeResponseJson())->pluck('id'));
    }

    /** @test */
    public function it_gets_a_single_grocery_lists()
    {
        $grocerylist = factory(GroceryList::class)->create()->load('items');

        $response = $this->get('/api/v1/grocery-list/' . $grocerylist->getKey());

        $response->assertStatus(200);
        $this->assertEquals($grocerylist->toArray(), $response->decodeResponseJson());
        $this->assertEquals($grocerylist->items->toArray(), $response->decodeResponseJson()['items']);
    }
}
