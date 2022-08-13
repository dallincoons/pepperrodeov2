<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroceryListItemGroupAddDefaultCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Entities\GroceryListItemGroup::where('category_id', 0)->with('recipe')->get()->each(function($item) {
            $recipe = \App\Entities\Recipe::where('id', $item->recipe_id)->withTrashed()->first();
            if($recipe) {
                dump('updating:');
                dump($item->id);
                $item->category_id = $recipe->category_id;
                $item->save();
            } else {
                dump('not updating:');
                dump($item->id);
            }
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
