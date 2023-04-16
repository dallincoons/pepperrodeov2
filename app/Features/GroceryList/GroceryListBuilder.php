<?php

namespace App\Features\GroceryList;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Entities\GroceryListItemGroup;
use App\Entities\ListableIngredient;
use App\Entities\Recipe;
use App\MealPlanGroup;
use App\Repositories\GroceryListItemRepository;

class GroceryListBuilder
{
	protected $groceryList;
	protected $collectedRecipes = [];
	protected $items = [];

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

	public function addRecipesFromMealPlan(MealPlanGroup $mealPlan)
	{
		foreach ($mealPlan->days as $day) {
			$this->collectRecipe($day->recipe, $day->category_id);
		}

		foreach ($this->collectedRecipes as $recipe) {
			/** @var CollectedRecipe $recipe */
			foreach ($recipe->getListableIngredients() as $li) {
				$this->collectItem(new CollectedItem($li->description, $li->quantity, $li->department_id, $recipe->getRecipeKey()), $recipe->getRecipeKey());
			}
		}

		foreach ($mealPlan->items as $item) {
			if (!$item->add_to_list) {
				continue;
			}

			$this->collectItem(new CollectedItem($item->title, 1, Department::DEFAULT_DEPT_ID, $recipe->getRecipeKey()), $recipe->getRecipeKey());
		}

		$groups = $this->saveGroups($this->collectedRecipes);

		$this->saveCollectedItems($this->items, $groups);

		return $this->groceryList;
	}

	private function collectRecipe(Recipe $recipe, $categoryId = null)
	{
		if ($categoryId == null) {
			if (count($recipe->categories) < 1) {
				return;
			}

			$categoryID = $recipe->categories->first()->getKey();
		}

		$this->collectedRecipes[] = new CollectedRecipe($recipe, $categoryId);

		foreach ($recipe->subRecipes as $subRecipe) {
			$this->collectRecipe($subRecipe, $categoryId);
		}

		foreach ($recipe->linkedRecipes as $recipe) {
			$this->collectRecipe($recipe, $categoryId);
		}
	}

	private function collectItem(CollectedItem $item, $recipeId)
	{
		$this->items[] = $item;
	}

	private function saveGroups(array $collectedRecipes)
	{
		$groupsToInsert = [];
		$groupsToRecipe = [];

		$collectedRecipeIds = collect($collectedRecipes)->map(function($recipe) { return $recipe->getRecipeKey(); });

		/** @var CollectedRecipe $recipe */
		foreach ($collectedRecipes as $recipe) {
			$groupsToInsert[] = [
				'grocery_list_id' => $this->groceryList->getKey(),
				'recipe_id' => $recipe->getRecipeKey(),
				'category_id'  => $recipe->getCategoryKey(),
			];
		}

		GroceryListItemGroup::insert($groupsToInsert);
		$groups = GroceryListItemGroup::where(['grocery_list_id' => $this->groceryList->getKey()])->whereIn('recipe_id', $collectedRecipeIds)->get();

		foreach ($groups as $group) {
			$groupsToRecipe[$group->recipe_id] = $group->getKey();
		}

		return $groupsToRecipe;
	}

	private function saveCollectedItems($collectedItems, $groups)
	{
		$itemsToInsert = collect($collectedItems)->map(function($item) use ($groups) {

			if (!array_key_exists($item->recipeId, $groups)) {
				return null;
			}

			$groupId = $groups[$item->recipeId];

			return [
				'description' => $item->description,
				'quantity' => $item->quantity,
				'department_id' => $item->departmentId,
				'grocery_list_id' => $this->groceryList->getKey(),
				'grocery_list_group_id' => $groupId,
			];
		})->filter()->all();

		GroceryListItem::insert($itemsToInsert);
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

	public function translateIngredient(ListableIngredient $ingredient, $recipeId)
	{
		return [
			'description'   => $ingredient->description,
			'quantity'      => $ingredient->quantity,
			'department_id' => $ingredient->department_id,
			'recipe_id'     => $recipeId,
		];
	}
}
