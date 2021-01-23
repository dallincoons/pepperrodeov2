<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealPlanGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('meal_plan_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('grocery_list_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('grocery_list_id')->references('id')->on('grocery_lists')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
