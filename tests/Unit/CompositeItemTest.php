<?php

namespace Tests\Unit;

use App\Entities\CompositeItem;
use App\Entities\Department;
use App\Entities\GroceryListItem;
use Tests\TestCase;

class CompositeItemTest extends TestCase
{
    /** @test */
    public function update_department_on_composite()
    {
        $composite = new CompositeItem(collect([
            factory(GroceryListItem::class)->create(),
            factory(GroceryListItem::class)->create(),
        ]));

        $department = factory(Department::class)->create();

        $composite->updateDepartment($department->getKey());

        $this->assertEquals($department->name, $composite->department());
    }

    /** @test */
    public function update_description_on_composite()
    {
        $composite = new CompositeItem(collect([
            $item = factory(GroceryListItem::class)->create(['quantity' => 11]),
            factory(GroceryListItem::class)->create(['quantity' => 22]),
        ]));

        $composite->updateDescription('the slackers');

        $this->assertEquals('the slackers', $composite->description());
        $this->assertEquals(11, $item->fresh()->quantity);
    }

    /** @test */
    public function update_quantity_on_composite()
    {
        $composite = new CompositeItem(collect([
            factory(GroceryListItem::class)->create(),
            factory(GroceryListItem::class)->create(),
        ]));

        $composite->updateQuantity(123);

        $this->assertEquals(123, $composite->quantity());
    }
}
