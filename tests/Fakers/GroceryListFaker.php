<?php

namespace Tests\Fakers;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;

class GroceryListFaker
{
    public static function withItems($count = 1)
    {
        $list = factory(GroceryList::class)->create();

        foreach(range(1, $count) as $i) {
            $item = factory(GroceryListItem::class)->create([
                'grocery_list_id' => $list->getKey()
            ]);
            $list->items()->save($item);
        }

        return $list;
    }
}
