<?php

namespace Tests\Feature;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItemGroup;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class AddRecipeToGroceryListTest extends TestCase
{
    /** @test */
    public function it_adds_all_listable_recipe_ingredients_to_list()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $department = factory(Department::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe, 'department_id' => $department->getKey()]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe, 'department_id' => $department->getKey()]);

        $this->assertCount(0, $grocerylist->items);

        $grocerylist->addRecipe($recipe);

        $this->assertCount(count($recipe->listableIngredients), $grocerylist->fresh()->items);
        $this->assertEquals($recipe->listableIngredients->first()->department_id, $grocerylist->fresh()->items->first()->department_id);
    }

    /** @test */
    public function it_adds_the_same_recipe_to_list_again()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);

        $this->assertCount(0, $grocerylist->items);

        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe);

        $this->assertCount((count($recipe->listableIngredients) * 2) + 2, $grocerylist->fresh()->items);
    }

    /** @test */
    public function grocery_list_items_are_grouped_by_recipe_added()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        factory(ListableIngredient::class)->create(['recipe_id' => $recipe]);

        $this->assertCount(0, $grocerylist->items);

        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe);

        $this->assertEquals(2, GroceryListItemGroup::count());

        $firstItem = $grocerylist->fresh()->items->first();
        $lastItem = $grocerylist->fresh()->items->last();

        $this->assertNotEquals($firstItem->group->getKey(), $lastItem->group->getKey());
        $this->assertEquals($recipe->getKey(), $firstItem->group->recipe_id);
        $this->assertEquals($recipe->getKey(), $lastItem->group->recipe_id);
    }

    /** @test */
    public function gets_a_list_of_recipes_through()
    {
        /** @var $grocerylist GroceryList */
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        $recipe2 = factory(Recipe::class)->create();

        $this->assertCount(0, $grocerylist->items);

        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe2);

        $this->assertCount(2, $grocerylist->recipes);
    }

    /** @test */
    public function get_unique_recipe_count()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $recipe = factory(Recipe::class)->create();
        $recipe2 = factory(Recipe::class)->create();

        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe);
        $grocerylist->addRecipe($recipe2);

        $this->assertEquals([
            $recipe->getKey() => 2,
            $recipe2->getKey() => 1
        ], $grocerylist->uniqueRecipeCount);
    }
}
