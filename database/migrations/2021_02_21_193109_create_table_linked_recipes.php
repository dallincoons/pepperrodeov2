<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLinkedRecipes extends Migration
{
    public function up()
    {
        Schema::create('linked_recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_recipe_id');
            $table->unsignedInteger('destination_recipe_id');
            $table->timestamps();

            $table->foreign('source_recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('destination_recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }
}
