<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_recipe', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedInteger('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
        });
    }
}
