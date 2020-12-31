<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecipeAddParentId extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable()->references('id')->on('recipes')->onDelete('cascade')->after('id');
        });
    }
}
