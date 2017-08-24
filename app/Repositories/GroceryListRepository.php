<?php

namespace App\Repositories;

use App\GroceryList;

class GroceryListRepository
{
    public static function all()
    {
        return GroceryList::all();
    }

    public static function store($data)
    {
        $grocerylist = GroceryList::create([
            'title'   => $data['title'],
            'user_id' => $data['user_id']
        ]);

        $items = array_get($data, 'items') ?: [];

        foreach($items as $item){
            $grocerylist->items()->create($item);
        }

        return $grocerylist;
    }
}
