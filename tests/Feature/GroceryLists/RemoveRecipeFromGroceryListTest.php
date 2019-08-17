<?php

namespace Tests\Feature\GroceryLists;

use App\Entities\GroceryList;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use Tests\TestCase;

class RemoveRecipeFromGroceryListTest extends TestCase
{
    /** @test */
    public function remove_recipe_from_grocery_list_and_all_associated_items()
    {
        $recipeA = create(Recipe::class);
        $recipeA->ingredients()->save(create(ListableIngredient::class));
        $recipeA->ingredients()->save(create(ListableIngredient::class));

        $recipeB = create(Recipe::class);
        $recipeB->ingredients()->save(create(ListableIngredient::class));
        $recipeB->ingredients()->save(create(ListableIngredient::class));

        $grocerylist = create(GroceryList::class);

        $grocerylist->addRecipe($recipeA);
        $grocerylist->addRecipe($recipeA);
        $grocerylist->addRecipe($recipeB);

        $this->assertCount(6, $grocerylist->items);

        $response = $this->delete(route('grocerylist.recipe.delete', [$grocerylist->getKey(), $recipeA->getKey()]));

        $this->assertCount(4, $grocerylist->fresh()->items);
        $this->assertCount(2, $grocerylist->getRecipesAttribute());
        $response->assertSuccessful();
    }
}
