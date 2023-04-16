<?php

namespace App\Features\MealPlanToList;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Features\GroceryList\GroceryListBuilder;
use App\MealPlanGroup;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Support\Facades\Date;

class ListFromMealPlanBuilder
{
	protected $mealPlan;
	protected $dateFilter;

    public function __construct(MealPlanGroup $mealPlan, DateFilter $dateFilter)
    {
		$this->mealPlan = $mealPlan;
		$this->dateFilter = $dateFilter;
	}

	public function buildList($name)
	{
		return \DB::transaction(function () use ($name) {
			return $this->doBuildList($name);
		});
	}

	public function doBuildList($name)
	{
		$daysQuery = $this->mealPlan->days();

		$daysQuery->whereDate("date", ">=", $this->dateFilter->startDate);
		$daysQuery->whereDate("date", "<=", $this->dateFilter->endDate);

		$grocerylist = GroceryList::create([
			'title' => $name,
			'user_id' => $this->mealPlan->user_id,
			'start_date' => $this->dateFilter->startDate,
			'end_date' => $this->dateFilter->endDate
		]);

		$builder =  new GroceryListBuilder($grocerylist);

		return $builder->addRecipesFromMealPlan($this->mealPlan);
	}
}
