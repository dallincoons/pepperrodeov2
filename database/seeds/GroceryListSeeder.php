<?php

use App\Entities\GroceryList;
use App\GroceryListItem;
use App\User;
use Illuminate\Database\Seeder;

class GroceryListSeeder extends Seeder
{
    public function run()
    {
        $listTitles = [
            'December First 2 Weeks List',
            'Hurricane, UT Trip Shopping List',
            'January 1st 3 Weeks',
            'January Last 2 Weeks',
        ];

        foreach($listTitles as $title){

            $grocerylist = GroceryList::create([
                'user_id' => User::first() ?  User::first()->getKey() : factory(User::class)->create()->getKey(),
                'title' => $title
            ]);

            foreach(range(1, rand(1, 20)) as $itemindex)
            {
                $item = factory(GroceryListItem::class)->create();
                $grocerylist->items()->save($item);
            }
        }
    }
}
