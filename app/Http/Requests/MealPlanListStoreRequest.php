<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealPlanListStoreRequest extends FormRequest
{
    public function getStartDate($mealPlanGroup)
    {
        if (!$this->start_date || $this->start_date < $mealPlanGroup->start_date) {
            return $mealPlanGroup->start_date;
        }

        return $this->start_date;
    }

    public function getEndDate($mealPlanGroup)
    {
        if (!$this->end_date || $this->end_date < $mealPlanGroup->end_date) {
            return $mealPlanGroup->end_date;
        }

        return $this->end_date;
    }

    public function rules() {
        return [];
    }
}
