<?php

namespace App\Features\GroceryList;

use App\Entities\Recipe;
use Illuminate\Support\Collection;

class CollectedRecipe
{
	public $recipe;
	public $categoryId;

	public function __construct(Recipe $recipe, $categoryId)
	{
		$this->recipe = $recipe;
		$this->categoryId = $categoryId;
	}

	public function getRecipeKey()
	{
		return $this->recipe->getKey();
	}

	public function getCategoryKey()
	{
		return $this->categoryId;
	}

	public function getCollectedItems() : Collection
	{
		 return $this->getListableIngredients()->map(function($ingredient) {
			 return new CollectedItem($ingredient, $this->getRecipeKey());
		 });
	}

	public function getListableIngredients()
	{
		return collect($this->recipe->listableIngredients);
	}
}
