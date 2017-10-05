<?php

namespace App\Observers;

use App\Entities\GroceryListItem;

class ExtractsQtyField
{
    public static function apply(GroceryListItem $item)
    {
        $description = $item->description;

        preg_match('/[^\s]+/', $description, $matches);

        if (!is_numeric($matches[0])) {
            return;
        }

        $item->quantity    = $matches[0];
        $item->description = trim(str_after($description, $matches[0]));
    }
}
