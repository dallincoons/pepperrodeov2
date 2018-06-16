<?php

use App\Entities\ListableIngredient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spacegrass\Fraction;

class AddFullListableDescriptionToIngredientTable extends Migration
{
    const TABLE = 'listable_ingredients';

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

        ListableIngredient::all()->each(function(ListableIngredient $ingredient) {
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
