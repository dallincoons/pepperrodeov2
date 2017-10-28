<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    const TABLE = 'categories';

    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
