<?php

namespace App\Entities;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Database\Eloquent\Model;

class GroceryListItem extends Model
{
    protected $fillable = [
        'grocery_list_id', 'grocery_list_group_id',
        'description', 'quantity',
        'is_checked', 'department_id'
    ];

    protected $casts = [
        'is_checked' => 'integer',
        'quantity' => 'integer',
    ];

    public function setMagicDescriptionAttribute($description)
    {
        $parser = DescriptionParserFactory::make($description);

        $this->attributes['description'] = $parser->getDescription();
        $this->attributes['quantity'] = $parser->getQuantity();
    }

    public function getQuantityAttribute()
    {
        return $this->attributes['quantity'] ?? 0;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function group()
    {
        return $this->belongsTo(GroceryListItemGroup::class, 'grocery_list_group_id');
    }

    public function toggleComplete()
    {
        return app(GroceryListItemRepository::class)->update([
            'is_checked' => (int)!$this->is_checked
        ], $this->getKey());
    }
}
