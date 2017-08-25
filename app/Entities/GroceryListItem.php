<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class GroceryListItem extends Model
{
    protected $fillable = [
        'grocery_list_id', 'description', 'quantity'
    ];

    public function toggleComplete()
    {
        $this->is_checked = (int)!$this->is_checked;

        $this->save();
    }
}
