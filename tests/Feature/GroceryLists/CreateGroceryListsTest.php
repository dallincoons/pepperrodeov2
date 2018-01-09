<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
use App\User;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group create-grocery-lists-tests
 * @group feature-tests
 */
class CreateGroceryListsTest extends TestCase
{
    /** @test */
    public function it_creates_a_grocery_list_without_items()
    {
        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 'Second half of June',
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, GroceryList::count());
    }

    /** @test */
    public function it_creates_a_grocery_list_with_items()
    {
        $response = $this->post('/api/v1/grocery-lists', [
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
                'description' => '2 banana',
            ],
            [
                'description' => '2 banana',
            ]
        ];

        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 'First half of July',
            'items' => $items
        ]);

        $response->assertStatus(201);
        $this->assertEquals('First half of July', GroceryList::first()->title);
        $this->assertArraySubset($items, GroceryList::first()->items->toArray());
    }

    /** @test */
    public function it_requires_a_title()
    {
        $this->withExceptionHandling();

        $response = $this->post('/api/v1/grocery-lists', [
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_requires_a_string_title()
    {
        $this->withExceptionHandling();

        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 1,
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_requires_items_to_be_an_array()
    {
        $this->withExceptionHandling();

        $response = $this->post('/api/v1/grocery-lists', [
            'items' => 1,
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_requires_description_to_be_present_in_item()
    {
        $this->withExceptionHandling();

        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 'check',
            'items' => [[
                'description',
                'quantity' => 123
            ]],
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_requires_item_description_to_be_a_string()
    {
        $this->withExceptionHandling();

        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 'check',
            'items' => [[
                'description' => 1,
                'quantity' => 123
            ]],
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function it_allows_item_quantity_to_be_nullable()
    {
        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 'check',
            'items' => [[
                'description' => 'fake',
            ]],
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_requires_item_quantity_to_be_an_integer()
    {
        $this->withExceptionHandling();

        $response = $this->post('/api/v1/grocery-lists', [
            'title' => 'check',
            'items' => [[
                'description' => 'fake',
                'quantity' => 'two'
            ]],
        ]);

        $response->assertStatus(400);
    }
}
