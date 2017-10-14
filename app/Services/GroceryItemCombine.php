<?php

namespace App\Services;

use App\Entities\GroceryList;
use App\Entities\GroceryListItem;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Support\Collection;
use Phospr\Fraction;

class GroceryItemCombine
{
    /**
     * @var GroceryListItemRepository
     */
    private $repository;
    /**
     * @var GroceryList
     */
    private $grocerylist;

    public function __construct(GroceryListItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Collection of GroceryListItems
     */
    public function combine(GroceryList $grocerylist)
    {
        $this->grocerylist = $grocerylist;
        $items                 = $this->grocerylist->items;
        $duplicates = $items->duplicates('description');

        foreach ($duplicates->groupBy('description') as $key => $duplicateItems) {
            $combinedItem = $this->mapToNewItem($duplicateItems);

            $items->push($combinedItem);
        }

        $items->forget(array_keys($duplicates->all()));

        return $items;
    }

    protected function combineFractions(Collection $items): string
    {
        return (string) $items->reduce(function ($original, $dupe) {
            return $original->add(Fraction::fromString($dupe->quantity));
        }, new Fraction(0));
    }

    /**
     * @param $duplicateItems
     * @return GroceryListItem
     */
    private function mapToNewItem($duplicateItems): GroceryListItem
    {
        $combinedItem = $this->repository->create([
            'grocery_list_id' => $this->grocerylist->getKey(),
            'description'     => $duplicateItems->first()->description,
            'quantity'        => $this->combineFractions($duplicateItems),
            'is_checked'      => 0,
        ]);
        return $combinedItem;
    }
}