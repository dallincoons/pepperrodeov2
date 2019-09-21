<?php

use App\Features\Categories\DefaultCategories;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreDefaultCategories extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table)
        {
            if (app()->runningUnitTests()) {
                return;
            }
            DefaultCategories::save();
        });
    }
}
