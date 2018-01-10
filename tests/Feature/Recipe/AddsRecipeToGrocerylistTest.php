<?php

namespace Tests\Feature\Recipe;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

class AddsRecipeToGrocerylistTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_ingredients_to_list_via_http()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);

        $this->assertCount(0, $grocerylist->items);

        $response = $this->post($this->api('grocerylist/'. $grocerylist->getKey() .'/add-recipe/' . $recipe->getKey()));

        $response->assertSuccessful();
        $this->assertCount(count($recipe->listableIngredients), $grocerylist->fresh()->items);
    }
}
