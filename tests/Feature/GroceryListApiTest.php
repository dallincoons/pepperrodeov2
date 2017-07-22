<?php

namespace Tests\Feature;

use App\GroceryList;
use App\User;
use Tests\TestCase;

class GroceryListApiTest extends TestCase
{
    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function it_gets_all_grocery_lists()
    {
        $grocerylists = factory(GroceryList::class, 2)->create();

        $response = $this->get('/api/v1/grocery-lists');
        $contents = $response->decodeResponseJson();

        $response->assertStatus(200);
        $this->assertCount(2, $contents);
        $this->assertEquals($grocerylists->pluck('id'), collect($response->decodeResponseJson())->pluck('id'));
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function it_gets_a_single_grocery_lists()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $response = $this->get('/api/v1/grocery-list/' . $grocerylist->getKey());

        $response->assertStatus(200);
        $this->assertEquals($grocerylist->toArray(), $response->decodeResponseJson());
    }

    /**
    * @group grocery-list-tests
    *
    * @test
    */
    public function it_creates_a_grocery_list()
    {
        $response = $this->post('/api/v1/grocery-list/create', [
            'title' => 'Second half of June',
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, GroceryList::count());
    }

    /**
     * @group grocery-list-tests
     *
    * @test
    */
    public function it_create_a_grocery_with_title()
    {
        $response = $this->post('/api/v1/grocery-list/create', [
            'title' => 'Second half of June',
        ]);

        $response->assertStatus(201);
        $this->assertEquals('Second half of June', GroceryList::first()->title);
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function it_create_a_grocery_with_another_title()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post('/api/v1/grocery-list/create', [
            'title' => 'First half of July',
        ]);

        $response->assertStatus(201);
        $this->assertEquals('First half of July', GroceryList::first()->title);
    }
}
