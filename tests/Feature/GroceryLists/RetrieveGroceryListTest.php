<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use Carbon\Carbon;
use Tests\Fakers\GroceryListFaker;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group retrieve-grocery-lists-tests
 * @group feature-tests
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
        $item = factory(GroceryListItem::class)->create();
        $grocerylist->items()->save($item);
        $grocerylist->refresh();

        $response = $this->get('/api/v1/grocery-list/' . $grocerylist->getKey());

        $response->assertStatus(200);
        $this->assertEquals($grocerylist->id, $response->decodeResponseJson()['id']);
        $this->assertEquals($grocerylist->items->first()->description, $response->decodeResponseJson()['items'][0]['description']);
    }

    /** @test */
    public function it_retrieves_grocery_list_with_combined_items()
    {
        $grocerylist = GroceryListFaker::withItems([
            [
                'description' => 'AAA',
                'quantity' => '1/4',
            ],
            [
                'description' => 'AAA',
                'quantity' => '2/4',
            ],
            [
                'description' => 'BBB',
                'quantity' => 1,
            ]
        ]);

        $response = $this->get($this->api('grocery-list/' . $grocerylist->getKey()));

        $response->assertSuccessful();
        $this->assertCount(3, $response->decodeResponseJson()['items']);
        $this->assertCount(2, $response->decodeResponseJson()['combinedItems']);
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
