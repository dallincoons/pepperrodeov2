<?php

namespace Tests\Feature\GroceryList;

use App\Entities\GroceryList;
use Tests\TestCase;

/**
 * @group grocery-list-tests
 * @group update-grocery-lists-tests
 */
class UpdateGroceryListsTest extends TestCase
{
    /** @test */
    public function it_updates_a_grocery_list()
    {
        $grocerylist = factory(GroceryList::class)->create([
            'title' => 'Banana sandwhich'
        ]);

        $this->patch('/api/v1/grocery-list/' . $grocerylist->getKey(), ['title' => 'Banana pie']);

        $this->assertEquals($grocerylist->fresh()->title, 'Banana pie');
    }
}
