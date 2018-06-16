<?php

use App\Entities\Ingredient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spacegrass\Fraction;

class AddFullDescriptionToIngredientTable extends Migration
{
    const TABLE = 'ingredients';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->string('full_description')->default('');
        });

        Ingredient::all()->each(function(Ingredient $ingredient) {
            $quantity = $ingredient->quantity ?? 1;
            $ingredient->full_description = Fraction::fromFloat($quantity) . ' ' . $ingredient->description;
            $ingredient->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
