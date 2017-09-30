<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
use Carbon\Carbon;
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
        $contents = $response->decodeResponseJson()['data'];

        $response->assertStatus(200);
        $this->assertCount(2, $contents);
        $this->assertEquals($grocerylists->pluck('id'), collect($contents)->pluck('id'));
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

    /** @test */
    public function lists_are_displayed_from_newest_to_youngest()
    {
        $newest = factory(GroceryList::class)->create([
            'created_at' => Carbon::now()
        ]);
        $second = factory(GroceryList::class)->create([
            'created_at' => Carbon::now()->subDay()
        ]);
        $oldest = factory(GroceryList::class)->create([
            'created_at' => Carbon::now()->subWeek()
        ]);

        $response = $this->get('/api/v1/grocery-lists')->decodeResponseJson()['data'];

        $this->assertEquals($newest->title, $response[0]['title']);
        $this->assertEquals($second->title, $response[1]['title']);
        $this->assertEquals($oldest->title, $response[2]['title']);
    }
}
