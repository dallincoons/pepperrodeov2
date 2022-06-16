<?php

namespace App\Http\Controllers;

use App\MealPlanItem;
use Illuminate\Http\Request;

class MealPlanItemController extends Controller {
    public function update($itemID, Request $request) {
        $item = MealPlanItem::find($itemID);

        if (!$item || $request->get('add_to_list') === null) {
            return response()->json(424);
        }

        $item->add_to_list = $request->get('add_to_list');

        $item->save();

        return response()->json(['item' => $item], 200);
    }
}
