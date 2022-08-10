<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroceryListItemGroupsAddCategoryId extends Migration
{
    public function up()
    {
        Schema::table('grocery_list_item_groups', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
        });
    }
}
