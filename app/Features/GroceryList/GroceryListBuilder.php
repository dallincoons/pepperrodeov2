<?php

namespace App\Features\GroceryList;

use App\Entities\GroceryList;
use App\Entities\GroceryListItemGroup;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use App\Repositories\GroceryListItemRepository;

class GroceryListBuilder
{
	protected $groceryList;

	public function __construct(GroceryList $groceryList)
	{
		$this->groceryList = $groceryList;
	}

	public function addRecipes(array $recipes, $categoryId = null)
	{
		foreach ($recipes as $recipe) {
			$this->addRecipe($recipe, $categoryId);
		}
	}

	public function addRecipe(Recipe $recipe, $categoryID = null)
	{
		if ($categoryID == null) {
			if (count($recipe->categories) < 1) {
				return;
			}

			$categoryID = $recipe->categories->first()->getKey();
		}

		/** @var GroceryListItemRepository $itemRepository */
		$itemRepository = app(GroceryListItemRepository::class);

		$group = GroceryListItemGroup::create([
			'grocery_list_id' => $this->groceryList->getKey(),
			'recipe_id' => $recipe->getKey(),
			'category_id'  => $categoryID,
		]);

		foreach ($recipe->listableIngredients as $ingredients) {
			$itemRepository->create(
				$this->translateIngredient($ingredients, $recipe)
				+ ['grocery_list_id' => $this->groceryList->getKey(), 'grocery_list_group_id' => $group->getKey()]
			);
		}

		$subRecipes = $recipe->subRecipes;
		if ($subRecipes->count() > 0) {
			foreach ($subRecipes as $subRecipe) {
				foreach ($subRecipe->listableIngredients as $ingredients) {
					$itemRepository->create(
						$this->translateIngredient($ingredients, $recipe)
						+ ['grocery_list_id' => $this->groceryList->getKey(), 'grocery_list_group_id' => $group->getKey()]
					);
				}
			}
		}

		$linkedRecipes = $recipe->linkedRecipes;
		if ($linkedRecipes->count() > 0) {
			$this->addRecipes($linkedRecipes->all(), $categoryID);
		}
	}

	public function translateIngredient(ListableIngredient $ingredient, Recipe $recipe)
	{
		return [
			'description'   => $ingredient->description,
			'quantity'      => $ingredient->quantity,
			'department_id' => $ingredient->department_id,
			'recipe_id'     => $recipe->getKey()
		];
	}
}
