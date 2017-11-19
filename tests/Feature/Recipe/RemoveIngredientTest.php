<?php

namespace Tests\Feature\Recipe;

use Tests\Fakers\RecipeFaker;
use Tests\TestCase;

class RemoveIngredientTest extends TestCase
{
    /** @test */
    public function it_removes_ingredient_from_recipe()
    {
        $recipe = RecipeFaker::withItems(2);

        $ingredient = $recipe->ingredients->first();

        $this->delete($this->api('ingredients/' . $ingredient->getKey()));

        $this->assertCount(1, $recipe->fresh()->ingredients);
    }

    /** @test */
    public function it_removes_listable_ingredient_from_recipe()
    {
        $recipe = RecipeFaker::withListableItems(2);

        $ingredient = $recipe->ingredients->first();

        $this->delete($this->api('listable_ingredients/' . $ingredient->getKey()));

        $this->assertCount(1, $recipe->fresh()->listableIngredients);
    }
}
