<?php

namespace Tests\Feature;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use Tests\TestCase;

class DeleteGroceryListItemsTest extends TestCase
{
    /** @test */
    public function it_deletes_a_grocery_list_item()
    {
        $list = factory(GroceryList::class)->create();
        $item1 = $list->items()->create(factory(GroceryListItem::class)->raw());
        $item2 = $list->items()->create(factory(GroceryListItem::class)->raw());

        $this->assertCount(2, $list->items);

        $this->delete('/api/v1/grocery-list-item/' . $item1->getKey());

        $list->refresh();
        $this->assertCount(1, $list->items);
        $this->assertTrue($list->items->first()->is($item2));
    }
}
