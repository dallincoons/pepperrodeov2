<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MealPlanDaysAddCategoryId extends Migration
{
    public function up()
    {
        Schema::table('meal_plan_days', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
        });
    }
}
