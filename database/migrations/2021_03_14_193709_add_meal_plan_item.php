<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMealPlanItem extends Migration
{
    public function up()
    {
        Schema::create('meal_plan_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('meal_plan_group_id');
            $table->date('date');
            $table->string('title');
            $table->timestamps();
        });
    }
}
