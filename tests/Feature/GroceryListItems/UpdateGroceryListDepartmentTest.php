<?php

namespace Tests\Feature\GroceryListItems;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use Tests\TestCase;

class UpdateGroceryListDepartmentTest extends TestCase
{
    /** @test */
    public function it_updates_a_grocery_list_item_department_with_composite_item()
    {
        $list = factory(GroceryList::class)->create();
        $list->items()->create($item = factory(GroceryListItem::class)->raw(['quantity' => 7]));
        $list->items()->create($item);

        $department = factory(Department::class)->create();

        $response = $this->patch(route('list.item.department.update', [
            'id' => $list->getKey(),
            'description' => $item['description'],
            'department_id' => $department->getKey(),
        ]));

        $response->assertStatus(200);
        foreach ($list->items->pluck('department_name') as $departmentName)
        {
             $this->assertEquals($department->name, $departmentName);
        }
    }
}
