<?php

namespace Tests\Feature\Recipe;

use App\Entities\Ingredient;
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
}
