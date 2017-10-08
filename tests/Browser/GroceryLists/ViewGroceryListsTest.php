<?php

namespace Tests\Browser\GroceryLists;

use App\Entities\GroceryList;
use Laravel\Dusk\Browser;
use Tests\Browser\LogsIn;
use Tests\DuskTestCase;
use Tests\Fakers\GroceryListFaker;

class ViewGroceryListsTest extends DuskTestCase
{
    use LogsIn;

    /** @test */
    public function it_views_index_of_all_grocery_lists()
    {
        $lists = factory(GroceryList::class, 2)->create();

        $this->browse(function (Browser $browser) use($lists) {
            $browser->visit('/');

            $browser->waitForText($lists->first()->title);

            foreach ($lists as $list) {
                $browser->assertSee($list->title);
            }
        });
    }

    /** @test */
    public function it_views_single_grocery_link_from_index_page()
    {
        $list = GroceryListFaker::withItems(2);

        $this->browse(function (Browser $browser) use($list) {
            $browser->visit('/');
            $browser->waitForText($list->title);
            $browser->clickLink($list->title);

            $browser->waitForText($list->items->first()->description);
            $browser->assertSee($list->items->first()->description);
        });
    }
}
