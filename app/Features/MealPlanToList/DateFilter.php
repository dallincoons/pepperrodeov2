<?php

namespace App\Features\MealPlanToList;

use Carbon\Carbon;

class DateFilter
{
	public $startDate;
	public $endDate;

	public function __construct(string $startDate, string $endDate)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
	}
}
