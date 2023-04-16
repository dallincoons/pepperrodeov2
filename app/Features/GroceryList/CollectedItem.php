<?php

namespace App\Features\GroceryList;

class CollectedItem
{
	public $description;
	public $quantity;
	public $departmentId;
	public $recipeId;

	public function __construct($description, $quantity, $departmentId, $recipeId)
	{
		$this->description = $description;
		$this->quantity = $quantity;
		$this->departmentId = $departmentId;
		$this->recipeId = $recipeId;
	}
}
