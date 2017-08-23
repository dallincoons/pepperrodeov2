<?php

namespace Tests\Feature;

use App\GroceryListItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @group grocery-list-items-feature-test
 */
class GroceryListItemCompletionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_marks_a_grocery_list_item_as_complete()
    {
        $item = factory(GroceryListItem::class)->create();

        $this->assertEquals(0, $item->is_checked);

        $this->post('/api/v1/grocery-list-item-completion/' . $item->getKey());

        $this->assertEquals(1, $item->fresh()->is_checked);
    }

    /** @test */
    public function it_marks_a_grocery_list_item_as_incomplete()
    {
        $item = factory(GroceryListItem::class)->create([
            'is_checked' => 1
        ]);

        $this->assertEquals(1, $item->is_checked);

        $this->post('/api/v1/grocery-list-item-completion/' . $item->getKey());

        $this->assertEquals(0, $item->fresh()->is_checked);
    }
}
