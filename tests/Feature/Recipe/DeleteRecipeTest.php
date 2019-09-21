<?php

namespace Tests\Feature\Recipe;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Entities\GroceryListItemGroup;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class DeleteRecipeTest extends TestCase
{
    /** @test */
    public function it_deletes_a_recipe()
    {
        $recipe = factory(Recipe::class)->create();
        factory(GroceryListItemGroup::class)->create(['recipe_id' => $recipe->getKey()]);

        $this->assertEquals(1, Recipe::count());

        $this->delete($this->api('recipes/' . $recipe->getKey()));

        $this->assertEquals(0, Recipe::count());
    }

    /** @test */
    public function it_keeps_grocery_list_items_when_recipe_is_deleted()
    {
        $recipe = factory(Recipe::class)->create();
        $groceryList = create(GroceryList::class);

        $groceryList->addRecipe($recipe);
        $group = factory(GroceryListItemGroup::class)->create(['recipe_id' => $recipe->getKey()]);
        $item = factory(GroceryListItem::class)->create(['grocery_list_group_id' => $group->getKey(), 'grocery_list_id' => $groceryList->getKey()]);

        $recipe->delete();

        $this->assertTrue($item->exists());
//        $this->assertNull($group->fresh()->recipe_id);
    }
}
