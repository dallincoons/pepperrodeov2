<?php

namespace Tests\Feature\GroceryLists;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

class RecentGroceryListTest extends TestCase
{
    /** @test */
    public function get_most_recent_grocery_list()
    {
        /** @var GroceryList $recent */
        $recent = factory(GroceryList::class)->create();

        $recent->addRecipe(factory(Recipe::class)->create());
        $recent->addRecipe(factory(Recipe::class)->create());

        $response = $this->get(route('grocery-list.recent'));

        $this->assertEquals($response->decodeResponseJson()['id'], $recent->getKey());
        $this->assertCount(2, $response->decodeResponseJson()['recipes']);
    }
}
