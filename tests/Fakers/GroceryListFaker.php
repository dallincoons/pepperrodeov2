<?php

namespace Tests\Fakers;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;

class GroceryListFaker
{
    public static function withItems($param)
    {
        if (is_numeric($param)) {
            $list = self::withItemCount($param);
        } elseif (is_array($param)) {
            $list = self::withItemArray($param);
        } else {
            $list = factory(GroceryList::class)->create();
        }

        return $list;
    }

    public static function withItemCount($count)
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

    public static function withItemArray(array $array)
    {
        $list = factory(GroceryList::class)->create();

        if(count($array) == count($array, COUNT_RECURSIVE)) {
            $array = [$array];
        }

        foreach($array as $item) {
            $itemData = array_merge([
                'grocery_list_id' => $list->getKey(),
            ], $item);
            $item = factory(GroceryListItem::class)->create($itemData);
            $list->items()->save($item);
        }

        return $list;
    }
}
