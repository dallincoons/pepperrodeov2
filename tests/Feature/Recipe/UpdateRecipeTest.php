<?php

namespace Tests\Feature\Recipe;

use App\Category;
use App\Entities\Department;
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
                    'full_description' => $ingredient->description . 'altered',
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
                    'full_description' => $ingredient->description . 'altered',
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
                    'full_description' => $ingredient->description . 'altered',
                    'quantity' => null
                ],
                [
                    'full_description' => 'beat on the brat',
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
                    'full_description' => $ingredient->description . 'altered',
                    'quantity' => null,
                ],
                [
                    'full_description' => 'beat on the brat',
                    'quantity' => 101,
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->listableIngredients);
    }

    /** @test */
    public function add_departmentalized_listable_ingredient_to_recipe_as_part_of_update()
    {
        $department = factory(Department::class)->create();

        $recipe = RecipeFaker::withItems();
        $ingredient = $recipe->listableIngredients->first();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'listable_ingredients' => [
                [
                    'id' => $ingredient->getKey(),
                    'full_description' => $ingredient->description . 'altered',
                    'quantity' => null,
                    'department_id' => $department->getKey()
                ],
                [
                    'full_description' => 'beat on the brat',
                    'quantity' => 101,
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertEquals($department->getKey(), array_get(Recipe::first()->listableIngredients->first()->toArray(), 'department_id'));
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

    /** @test */
    public function it_updates_sub_recipe()
    {
        $recipe = RecipeFaker::withItems();
        $subRecipe = create(Recipe::class, ['parent_id' => $recipe]);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipe' => [
                'id' => $subRecipe->getKey(),
                'title' => 'updated subrecipe title',
            ]
        ]);

        $response->assertStatus(200);
        $this->assertEquals('updated subrecipe title', $subRecipe->refresh()->title);
    }

    /** @test */
    public function it_deletes_ingredients()
    {
        $recipe = RecipeFaker::withItems(3);

        $this->assertCount(3, $recipe->ingredients);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'ingredients' => [
                [
                    'id' => $recipe->ingredients->first()->getKey(),
                    'full_description' => $recipe->ingredients->first()->description . 'altered',
                    'quantity' => 1
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $recipe->fresh()->ingredients);

//        $this->assertEquals('updated subrecipe title', $subRecipe->refresh()->title);
    }
}
