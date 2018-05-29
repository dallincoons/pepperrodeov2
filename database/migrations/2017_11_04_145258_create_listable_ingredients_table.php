<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListableIngredientsTable extends Migration
{
    const TABLE = 'listable_ingredients';

    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('recipe_id');
            $table->string('quantity')->nullable();
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
