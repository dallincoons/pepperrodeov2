<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddToListFieldToMealPlanItem extends Migration
{
    public function up()
    {
        Schema::table('meal_plan_items', function (Blueprint $table) {
            $table->boolean('add_to_list')->default(true);
        });
    }
}
