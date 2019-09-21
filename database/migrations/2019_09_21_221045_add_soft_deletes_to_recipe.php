<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToRecipe extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table)
        {
            $table->softDeletes();
        });
    }
}
