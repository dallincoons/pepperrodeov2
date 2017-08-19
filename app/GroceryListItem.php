<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryListItem extends Model
{
    protected $fillable = [
        'description', 'quantity'
    ];

    public function toggleComplete()
    {
        $this->is_checked = (int)!$this->is_checked;
    }
}
