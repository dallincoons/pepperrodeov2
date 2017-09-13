<?php

namespace App\Entities;

use App\Repositories\GroceryListItemRepository;
use Illuminate\Database\Eloquent\Model;

class GroceryListItem extends Model
{
    protected $fillable = [
        'grocery_list_id', 'description', 'quantity', 'is_checked', 'department_id'
    ];

    protected $casts = [
        'is_checked' => 'integer'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function toggleComplete()
    {
        return app(GroceryListItemRepository::class)->update([
            'is_checked' => (int)!$this->is_checked
        ], $this->getKey());
    }
}
