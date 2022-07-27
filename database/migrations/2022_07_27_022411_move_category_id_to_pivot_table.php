<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveCategoryIdToPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Entities\Recipe::all()->each(function($recipe) {
            $categoryId = $recipe->category_id;

            \App\CategoryRecipe::create([
                'recipe_id' => $recipe->getKey(),
                'category_id' => $categoryId,
            ]);
        });

        Schema::table('recipes', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->nullable()->change();
        });
    }
}
