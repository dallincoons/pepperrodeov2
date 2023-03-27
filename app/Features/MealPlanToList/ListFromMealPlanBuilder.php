<?php

namespace App\Features\MealPlanToList;

use App\Entities\Department;
use App\Entities\GroceryList;
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
		$daysQuery = $this->mealPlan->days();

		$daysQuery->whereDate("date", ">=", $this->dateFilter->startDate);
		$daysQuery->whereDate("date", "<=", $this->dateFilter->endDate);

		$grocerylist = GroceryList::create(['title' => $name, 'user_id' => $this->mealPlan->user_id, 'start_date' => $this->dateFilter->startDate, 'end_date' => $this->dateFilter->endDate]);

		$daysQuery->get()->each(function($day) use ($grocerylist) {
			$grocerylist->addRecipe($day->recipe, $day->category_id);
		});

		$itemRepository = app(GroceryListItemRepository::class);

		$items = $this->mealPlan->items;

		foreach ($items as $item) {
			if (!$item->add_to_list) {
				continue;
			}

			$itemRepository->create([
				'grocery_list_id' => $grocerylist->getKey(),
				'description'   => $item->title,
				'quantity'      => 1,
				'department_id' => Department::DEFAULT_DEPT_ID,
			]);
		}

		return $grocerylist;
	}
}
