<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroceryListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grocery_list_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grocery_list_id');
            $table->unsignedInteger('department_id');
            $table->string('description')->nullable();
            $table->string('quantity')->nullable();
            $table->boolean('is_checked')->default(0);
            $table->timestamps();

            $table->foreign('grocery_list_id')->references('id')->on('grocery_lists')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grocery_list_items');
    }
}
