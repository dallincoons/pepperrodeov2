<?php

namespace App\Features\GroceryList;

class CollectedItem
{
	public $description;
	public $quantity;
	public $departmentId;
	public $recipeId;
	public $date;

	public function __construct($description, $quantity, $departmentId, $recipeId, $date)
	{
		$this->description = $description;
		$this->quantity = $quantity;
		$this->departmentId = $departmentId;
		$this->recipeId = $recipeId;
		$this->date = $date;
	}
}
