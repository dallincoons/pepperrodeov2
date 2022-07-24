<?php

namespace Tests\Feature\Recipe;

use App\Category;
use App\Entities\Department;
use App\Entities\Recipe;
use App\Features\Recipes\RecipeLinker;
use App\LinkedRecipe;
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
    public function it_creates_recipe_with_categories()
    {
//        $this->withExceptionHandling();

        $recipe = factory(Recipe::class)->create();
        $categoryA = factory(Category::class)->create();
        $categoryB = factory(Category::class)->create();
        $categoryC = factory(Category::class)->create();

        $recipe->categories()->sync([$categoryC->getKey()]);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'categories' => [
                $categoryA->getKey(),
                $categoryB->getKey(),
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->categories);
        $this->assertEquals($categoryA->getKey(), $recipe->fresh()->categories->first()->getKey());
        $this->assertEquals($categoryB->getKey(), $recipe->fresh()->categories->last()->getKey());
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

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipes' => [[
                'title' => 'updated subrecipe title',
                'directions' => '',
            ]]
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $recipe->subRecipes);
        $this->assertEquals('updated subrecipe title', $recipe->subRecipes->first()->title);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipes' => [[
                'id' => $recipe->subRecipes->first()->getKey(),
                'title' => 'updated subrecipe title2',
            ]]
        ]);

        $this->assertCount(1, $recipe->subRecipes);
        $response->assertStatus(200);
        $this->assertEquals('updated subrecipe title', $recipe->subRecipes->first()->title);
    }

    /** @test */
    public function it_deletes_sub_recipe()
    {
        $recipe = RecipeFaker::withItems();

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipes' => [[
                'title' => 'updated subrecipe title',
                'directions' => '',
            ]]
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $recipe->subRecipes);
        $this->assertEquals('updated subrecipe title', $recipe->subRecipes->first()->title);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipes' => [
                [
                    'id' => $recipe->subRecipes->first()->getKey(),
                    'title' => 'updated subrecipe title',
                    'directions' => '',
                ],
                [
                    'title' => 'updated subrecipe2 title',
                    'directions' => '',
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->subRecipes);
        $this->assertEquals('updated subrecipe2 title', $recipe->fresh()->subRecipes[1]->title);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipes' => [
                [
                    'id' => $recipe->subRecipes->first()->getKey(),
                    'title' => 'updated subrecipe title',
                    'directions' => '',
                ],
                [
                    'id' => $recipe->fresh()->subRecipes[1]->getKey(),
                    'title' => 'updated subrecipe2 title',
                    'directions' => '',
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->subRecipes);
        $this->assertEquals('updated subrecipe2 title', $recipe->fresh()->subRecipes[1]->title);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'sub_recipes' => [
                [
                    'id' => $recipe->subRecipes->first()->getKey(),
                    'title' => 'updated subrecipe title',
                    'directions' => '',
                ],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $recipe->fresh()->subRecipes);
        $this->assertEquals('updated subrecipe title', $recipe->fresh()->subRecipes->first()->title);
    }

    /** @test */
    public function it_updates_linked_recipes()
    {
        $recipe = create(Recipe::class);
        $linkedRecipeA = create(Recipe::class);
        $linkedRecipeB = create(Recipe::class);

        RecipeLinker::link($recipe->getKey(), $linkedRecipeA->getKey());

        $this->assertCount(1, $recipe->fresh()->linkedRecipes);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'title' => 'updated title',
            'linked_recipes' => [
                $linkedRecipeA->getKey(),
                $linkedRecipeB->getKey(),
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $recipe->fresh()->linkedRecipes);
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
    }

    /** @test */
    public function it_deletes_listable_ingredients()
    {
        $recipe = RecipeFaker::withListableItems(3);

        $this->assertCount(3, $recipe->listableIngredients);

        $response = $this->patch($this->api('recipes/' . $recipe->getKey()), [
            'listable_ingredients' => [
                [
                    'id' => $recipe->listableIngredients->first()->getKey(),
                    'full_description' => $recipe->listableIngredients->first()->description . 'altered',
                    'quantity' => 1
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $recipe->fresh()->listableIngredients);
    }
}
