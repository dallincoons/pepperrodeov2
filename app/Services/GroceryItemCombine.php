<?php

namespace App\Services;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use Illuminate\Support\Collection;
use Phospr\Fraction;

class GroceryItemCombine
{
    /**
     * @return Collection of GroceryListItems
     */
    public static function combine(GroceryList $grocerylist)
    {
        $items                 = $grocerylist->items;
        $unique                = $items->pluck('description')->unique();
        $duplicateDescriptions = $items->pluck('description')->diffAssoc($unique);

        foreach ($duplicateDescriptions as $description) {

            $duplicateItems = $items->filter(function ($item) use ($description) {
                return $item->description == $description;
            });

            $mergedQuantity = $duplicateItems->reduce(function ($original, $dupe) {
                return $original->add(Fraction::fromString($dupe->quantity));
            }, new Fraction(0));

            $items->forget($duplicateItems->keys()->all());

            $firstDuplicate = $duplicateItems->first();

            $combinedItem = GroceryListItem::create([
                'grocery_list_id' => $grocerylist->getKey(),
                'description'     => $firstDuplicate->description,
                'quantity'        => (string)$mergedQuantity,
                'is_checked'      => 0,
            ]);

            $items->push($combinedItem);
        }

        return $items;
    }
}
