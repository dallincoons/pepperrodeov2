<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecipeCascadeToItemGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grocery_list_item_groups', function (Blueprint $table) {
            $table->unsignedInteger('recipe_id')->nullable()->change();
//            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('set null');
        });
    }
}
