<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
use Tests\Behavior\EnablesSearchDriver;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group searches-grocery-list-tests
 * @group integration-tests
 * @group feature-tests
 */
class SearchesGroceryListsTest extends TestCase
{
    use EnablesSearchDriver;

    public function setUp()
    {
        parent::setUp();

        factory(GroceryList::class)->create([
            'title' => 'ABBB'
        ]);

        factory(GroceryList::class)->create([
            'title' => 'BCCC'
        ]);
    }

    /** @test */
    public function it_searches_for_grocery_lists()
    {
        $result = GroceryList::search('A')->get();

        $this->assertCount(1, $result);
        $this->assertEquals('ABBB', $result->first()->title);
    }

    /** @test */
    public function it_searches_through_api()
    {
        $response = $this->get('api/v1/grocery-lists/search?query=A');

        $result = $response->decodeResponseJson();

        $this->assertCount(1, $result);
        $this->assertEquals('ABBB', $result[0]['title']);
    }
}
