<?php

namespace App\Observers;

use App\Entities\GroceryListItem;

class ExtractsQtyField
{
    public function __construct($description)
    {

    }

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

    public static function getNumeric($description)
    {
        preg_match('/[^\s]+/', $description, $matches);

        return $matches[0];
    }

    public static function getDescription($description)
    {
        preg_match('/[^\s]+/', $description, $matches);

        return trim(str_after($description, $matches[0]));
    }

    public static function hasNumeric($description)
    {
        preg_match('/[^\s]+/', $description, $matches);

        return is_numeric($matches[0]);
    }
}
