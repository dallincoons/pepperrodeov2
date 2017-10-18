<?php

namespace Tests\Feature\GroceryListItems;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class UpdateGroceryListItemTest extends TestCase
{
    /** @test */
    public function it_updates_a_grocery_list_item_description()
    {
        $list = factory(GroceryList::class)->create();
        $item = $list->items()->create(factory(GroceryListItem::class)->raw());

        $response = $this->patch('/api/v1/grocery-list-item/' . $item->getKey(), [
            'description' => $item->description . 'altered'
        ]);

        $response->assertStatus(200);
        $this->assertEquals($item->fresh()->description,$item->description . 'altered');
    }

    /** @test */
    public function it_updates_a_grocery_list_item_department()
    {
        $list = factory(GroceryList::class)->create();
        $item = $list->items()->create(factory(GroceryListItem::class)->raw());

        $department = factory(Department::class)->create();

        $response = $this->patch('/api/v1/grocery-list-item/' . $item->getKey(), [
            'department_id' => $department->getKey()
        ]);

        $response->assertStatus(200);
        $this->assertEquals($item->fresh()->department_id, $department->getKey());
    }

    /** @test */
    public function it_only_allows_a_valid_description()
    {
        $this->withExceptionHandling();

        $list = factory(GroceryList::class)->create();
        $item = $list->items()->create(factory(GroceryListItem::class)->raw());

        $response = $this->patch('/api/v1/grocery-list-item/' . $item->getKey(), [
            'description' => 1234
        ]);

        $response->assertStatus(400);
        $this->assertEquals($item->fresh()->description, $item->description);
    }
}
