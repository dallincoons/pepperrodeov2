<?php

namespace Tests\Feature\Recipe;

use App\Category;
use App\Entities\Recipe;
use Tests\Fakers\RecipeFaker;
use Tests\TestCase;

class UpdateRecipeTest extends TestCase
{
    /** @test */
    public function it_updates_recipe_title()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => $recipe->title . 'altered'
        ]);

        $this->assertEquals($recipe->title . 'altered', $recipe->fresh()->title);
        $this->assertEquals($recipe->title . 'altered', $response->decodeResponseJson()['title']);
    }

    /** @test */
    public function it_updates_recipe_category()
    {
        $this->withExceptionHandling();

        $recipe = factory(Recipe::class)->create();
        $category = factory(Category::class)->create();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'category_id' => $category->getKey()
        ]);

        $response->assertStatus(200);
        $this->assertEquals($category->getKey(), $recipe->fresh()->category->getKey());
    }

    /** @test */
    public function it_updates_recipe_ingredients()
    {
        $recipe = RecipeFaker::withItems();
        $ingredient = $recipe->ingredients->first();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'ingredients' => [
                [
                    'id' => $ingredient->getKey(),
                    'description' => $ingredient->description . 'altered',
                    'quantity' => null
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertEquals($recipe->fresh()->ingredients->first()->description, $ingredient->description . 'altered');
    }

    /** @test */
    public function it_updates_recipe_listable_ingredients()
    {
        $recipe = RecipeFaker::withItems();
        $ingredient = $recipe->listableIngredients->first();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'listable_ingredients' => [
                [
                    'id' => $ingredient->getKey(),
                    'description' => $ingredient->description . 'altered',
                    'quantity' => null
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertEquals($recipe->fresh()->listableIngredients->first()->description, $ingredient->description . 'altered');
    }


    /** @test */
    public function add_ingredients_to_recipe_as_part_of_update()
    {
        $recipe = RecipeFaker::withItems();
        $ingredient = $recipe->ingredients->first();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'ingredients' => [
                [
                    'id' => $ingredient->getKey(),
                    'description' => $ingredient->description . 'altered',
                    'quantity' => null
                ],
                [
                    'description' => 'beat on the brat',
                    'quantity' => 101
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->ingredients);
    }

    /** @test */
    public function add_listable_ingredients_to_recipe_as_part_of_update()
    {
        $recipe = RecipeFaker::withItems();
        $ingredient = $recipe->listableIngredients->first();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'listable_ingredients' => [
                [
                    'id' => $ingredient->getKey(),
                    'description' => $ingredient->description . 'altered',
                    'quantity' => null
                ],
                [
                    'description' => 'beat on the brat',
                    'quantity' => 101
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->listableIngredients);
    }

    /** @test */
    public function updating_title_requires_string()
    {
        $this->withExceptionHandling();

        $recipe = factory(Recipe::class)->create();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => []
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function updating_directions_requires_string()
    {
        $this->withExceptionHandling();

        $recipe = factory(Recipe::class)->create();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'directions' => []
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function updating_directions_requires_integer()
    {
        $this->withExceptionHandling();

        $recipe = factory(Recipe::class)->create();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'category_id' => []
        ]);

        $response->assertStatus(400);
    }
}
