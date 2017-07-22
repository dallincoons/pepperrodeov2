<?php

use App\GroceryList;
use Illuminate\Database\Seeder;

class GroceryListSeeder extends Seeder
{
    public function run()
    {
        collect([
            'December First 2 Weeks List',
            'Hurricane, UT Trip Shopping List',
            'January 1st 3 Weeks',
            'January Last 2 Weeks',
            'February 6 - 19',
            'Costco Feb 6 - 19',
            'Sprouts Feb 6 -19',
            'Feb Last Two Weeks',
            'March 1st 2 weeks',
            'March Last half of month',
            'Costco March',
            'second half of April',
            'May first half',
            '1st half of June',
            'June 2nd half',
            'Late July',
        ])->each(function($title){
            factory(GroceryList::class)->create([
                'title' => $title
            ]);
        });


    }
}
