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
            $item = factory(GroceryListItem::class)->create(['quantity' => 1]),
            factory(GroceryListItem::class)->create(['quantity' => 2]),
        ]));

        $this->assertEquals(3, $composite->quantity());
        $composite->updateDescription('11 slackers');

        $this->assertEquals('slackers', $composite->description());
        $this->assertEquals(11, $composite->quantity());
    }

    /** @test */
    public function marks_multiple_item_composite_as_non_implicit_quantity()
    {
        $composite = new CompositeItem(collect([
            $item = factory(GroceryListItem::class)->create(['quantity' => 1]),
            factory(GroceryListItem::class)->create(['quantity' => 2]),
        ]));

        $this->assertEquals(3, $composite->quantity());
        $composite->updateDescription('11 slackers');

        $this->assertFalse($composite->hasImplicitQuantity());
    }

    /** @test */
    public function marks_single_item_composite_numeric_item_as_non_implicit_quantity()
    {
        $composite = new CompositeItem(collect([
            $item = factory(GroceryListItem::class)->create(['quantity' => 1]),
        ]));

        $this->assertEquals(1, $composite->quantity());
        $composite->updateDescription('1 slacker');

        $this->assertFalse($composite->hasImplicitQuantity());
    }

    /** @test */
    public function marks_numeric_description_as_non_implicit_quantity()
    {
        $composite = new CompositeItem(collect([
            $item = factory(GroceryListItem::class)->create(['quantity' => 1]),
            factory(GroceryListItem::class)->create(['quantity' => 2]),
        ]));

        $this->assertEquals(3, $composite->quantity());
        $composite->updateDescription('11 slackers');

        $this->assertFalse($composite->hasImplicitQuantity());
    }

    /** @test */
    public function marks_non_numeric_description_as_implicit_quantity()
    {
        $composite = new CompositeItem(collect([
            $item = factory(GroceryListItem::class)->create(['quantity' => 1]),
        ]));

        $this->assertEquals(1, $composite->quantity());
        $composite->updateDescription('slacker');

        $this->assertTrue($composite->hasImplicitQuantity());
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
