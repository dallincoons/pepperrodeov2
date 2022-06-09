<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImplicitQtyToGroceryListItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grocery_list_items', function (Blueprint $table) {
            $table->boolean('implicitQty')->default(false);
        });
    }
}
