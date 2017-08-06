<?php

namespace Tests\Feature;

use App\GroceryList;
use App\User;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group create-grocery-lists-tests
 */
class CreateGroceryListsTest extends TestCase
{
    /** @test */
    public function it_creates_a_grocery_list_without_items()
    {
        $response = $this->post('/api/v1/grocery-list/create', [
            'title' => 'Second half of June',
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, GroceryList::count());
    }

    /** @test */
    public function it_creates_a_grocery_list_with_items()
    {
        $response = $this->post('/api/v1/grocery-list/create', [
            'title' => 'Second half of June',
            'items'  => [[
                'description' => 'blah blah',
                'quantity' => 2
            ]]
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, GroceryList::count());
        $this->assertArraySubset([
            'description' => 'blah blah',
            'quantity' => 2
        ], GroceryList::first()->items->first()->toArray());
    }

    /** @test */
    public function it_create_a_grocery_with_title()
    {
        $this->be(factory(User::class)->create());

        $items = [
            [
                'description' => 'banana',
                'quantity'      => 2
            ],
            [
                'description' => 'banana',
                'quantity'      => 2
            ]
        ];

        $response = $this->post('/api/v1/grocery-list/create', [
            'title' => 'First half of July',
            'items' => $items
        ]);

        $response->assertStatus(201);
        $this->assertEquals('First half of July', GroceryList::first()->title);
        $this->assertArraySubset($items, GroceryList::first()->items->toArray());
    }
}
