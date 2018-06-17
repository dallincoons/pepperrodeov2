<?php

namespace Tests\Feature\GroceryListItems;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use Tests\TestCase;

/**
 * @group feature-tests
 */
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

    /** @test */
    public function it_requires_a_grocery_list_id()
    {
        $this->withExceptionHandling();

        $this->assertCount(0, $this->grocerylist->fresh()->items);

        $response = $this->createGroceryListItem([
            'grocery_list_id' => null
        ]);

        $response->assertStatus(400);
        $this->assertCount(0, $this->grocerylist->fresh()->items);
    }

    /** @test */
    public function it_creates_item_with_department()
    {
        $department = factory(Department::class)->create([
            'name' => 'Prodeuce'
        ]);

        $response = $this->createGroceryListItem([
            'department_id' => $department->getKey()
        ]);

        $newDepartment = $this->grocerylist->items()->first()->department->getKey();

        $response->assertStatus(201);
        $this->assertEquals($department->getKey(), $newDepartment);
    }

    /** @test */
    public function it_creates_item_with_quantity()
    {
        $this->createGroceryListItem([
            'description' => '12 check'
        ]);

        $groceryListItem = GroceryListItem::first();

        $this->assertEquals(12, $groceryListItem->quantity);
        $this->assertEquals('check', $groceryListItem->description);
    }

    /** @test */
    public function it_extracts_quantity_from_description()
    {
        $groceryListItem = factory(GroceryListItem::class)->create([
            'magic_description' => '2 round squishy things'
        ]);

        $groceryListItem->refresh();

        $this->assertEquals(2, $groceryListItem->quantity);
        $this->assertEquals('round squishy things', $groceryListItem->description);
    }

    /** @test */
    public function it_does_not_extract_non_numeric_description()
    {
        $grocerylist = factory(GroceryListItem::class)->create([
            'description' => 'round squishy things',
            'quantity'    => null
        ]);

        $grocerylist->refresh();

        $this->assertEquals(1, $grocerylist->quantity);
        $this->assertEquals('round squishy things', $grocerylist->description);
    }

    /** @test */
    public function it_does_not_extract_numeric_characters_in_other_parts_of_description()
    {
        $grocerylist = factory(GroceryListItem::class)->create([
            'description' => 'round 12 squishy 13 things',
            'quantity'    => null
        ]);

        $grocerylist->refresh();

        $this->assertEquals(1, $grocerylist->quantity);
        $this->assertEquals('round 12 squishy 13 things', $grocerylist->description);
    }

    protected function createGroceryListItem($overrides = [])
    {
        $response = $this->post('/api/v1/grocery-list-item', array_merge([
            'grocery_list_id' => $this->grocerylist->getKey(),
            'description' => 'Big box of donuts',
        ], $overrides));

        return $response;
    }
}
