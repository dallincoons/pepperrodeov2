<?php

namespace Tests\Feature;

use App\Entities\GroceryList;
use Tests\TestCase;

class CreateGroceryListItemTest extends TestCase
{
    private $grocerylist;

    public function setUp()
    {
        parent::setUp();

        $this->grocerylist = factory(GroceryList::class)->create();
    }

    /** @test */
    public function it_creates_a_grocery_list_item()
    {
        $this->assertCount(0, $this->grocerylist->fresh()->items);

        $response = $this->createGroceryListItem();

        $response->assertStatus(201);
        $this->assertCount(1, $this->grocerylist->fresh()->items);
    }

    /** @test */
    public function it_fails_validation_when_description_is_not_a_string()
    {
        $this->withExceptionHandling();

        $this->assertCount(0, $this->grocerylist->items);

        $response = $this->post('/api/v1/grocery-list-item', [
            'description' => 123,
        ]);

        $response->assertStatus(400);
        $this->assertCount(0, $this->grocerylist->fresh()->items);
    }

    /** @test */
    public function it_fails_validation_when_quantity_is_not_an_integer()
    {
        $this->withExceptionHandling();

        $this->assertCount(0, $this->grocerylist->items);

        $response = $this->post('/api/v1/grocery-list-item', [
            'quantity' => 'not an integer',
        ]);

        $response->assertStatus(400);
        $this->assertCount(0, $this->grocerylist->fresh()->items);
    }

    protected function createGroceryListItem($overrides = [])
    {
        $response = $this->post('/api/v1/grocery-list-item', array_merge([
            'grocery_list_id' => $this->grocerylist->getKey(),
            'description' => 'Big box of donuts',
            'quantity'    => 13
        ], $overrides));

        return $response;
    }
}
