<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealPlanDaysTable extends Migration
{
    public function up()
    {
        Schema::create('meal_plan_days', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('meal_plan_group_id');
            $table->unsignedInteger('recipe_id');
            $table->date('date');
            $table->timestamps();

            $table->foreign('meal_plan_group_id')->references('id')->on('meal_plan_groups')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }
}
