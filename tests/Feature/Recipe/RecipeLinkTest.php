<?php

namespace Tests\Feature\Recipe;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use App\Features\Recipes\RecipeLinker;
use App\LinkedRecipe;
use Tests\TestCase;

/**
 * @group feature-tests
 */
class RecipeLinkTest extends TestCase
{
    /** @test */
    public function link_a_recipe_to_another_recipe()
    {
        $source = create(Recipe::class, ['title' => 'source']);
        $destination = create(Recipe::class, ['title' => 'destination']);
        $destination2 = create(Recipe::class, ['title' => 'destination2']);

        $this->post(route('recipe_link.store'), [
            'source_recipe_id' => $source->getKey(),
            'destination_recipe_id' => $destination->getKey(),
        ]);

        $this->post(route('recipe_link.store'), [
            'source_recipe_id' => $source->getKey(),
            'destination_recipe_id' => $destination2->getKey(),
        ]);

        $this->assertCount(2, $source->linkedRecipes);
    }

    /** @test */
    public function add_linked_recipes_ingredients_when_creating_grocery_list()
    {
        $source = create(Recipe::class, ['title' => 'source']);

        create(ListableIngredient::class, [
            'recipe_id' => $source->getKey(),
            'quantity' => 1,
            'full_description' => 'genetics',
        ]);

        $destination = create(Recipe::class, ['title' => 'destination']);

        create(ListableIngredient::class, [
            'recipe_id' => $destination->getKey(),
            'quantity' => 1,
            'full_description' => 'brownies',
        ]);

        $destination2 = create(Recipe::class, ['title' => 'destination2']);

        create(ListableIngredient::class, [
            'recipe_id' => $destination2->getKey(),
            'quantity' => 1,
            'full_description' => 'dinks',
        ]);

       RecipeLinker::link($source->getKey(), $destination->getKey());
       RecipeLinker::link($source->getKey(), $destination2->getKey());

        $groceryList = create(GroceryList::class);

        $groceryList->addRecipe($source);

        $this->assertCount(3, $groceryList->items);
        $this->assertEquals([
            'genetics',
            'brownies',
            'dinks',
        ], $groceryList->items->pluck('description')->toArray());
    }
}
