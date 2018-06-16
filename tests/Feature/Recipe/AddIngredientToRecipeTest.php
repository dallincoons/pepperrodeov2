<?php

namespace Tests\Feature\Recipe;

use App\Entities\Ingredient;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

class AddIngredientToRecipeTest extends TestCase
{
    /** @test */
    public function add_ingredients_to_recipe()
    {
        $recipe = factory(Recipe::class)->create();

        $this->post($this->api('recipe/' . $recipe->getKey() .'/add-ingredients'), [ 'ingredients' => [
            factory(Ingredient::class)->raw()
        ]]);

        $this->assertCount(1, $recipe->ingredients);
    }

    /** @test */
    public function add_listable_ingredients_to_recipe()
    {
        $recipe = factory(Recipe::class)->create();

        $this->post($this->api('recipe/' . $recipe->getKey() .'/add-ingredients'), [ 'listable_ingredients' => [
            [
                'full_description' => '1 can manwhich',
                'recipe_id'   => $recipe->getKey()
            ]
        ]]);

        $this->assertCount(1, $recipe->listableIngredients);
        $this->assertEquals(1, $recipe->listableIngredients->first()->quantity);
        $this->assertEquals('can manwhich', $recipe->listableIngredients->first()->description);
    }
}
