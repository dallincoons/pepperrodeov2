<?php

namespace App\Entities;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
use App\Repositories\GroceryListItemRepository;
use Illuminate\Database\Eloquent\Model;

class GroceryListItem extends Model
{
    const DEFAULT_QUANTITY = 1;

    protected $fillable = [
        'grocery_list_id', 'grocery_list_group_id',
        'description', 'quantity', 'implicitQty',
        'is_checked', 'department_id'
    ];

    protected $casts = [
        'is_checked' => 'integer',
        'quantity' => 'integer',
        'implicitQty' => 'boolean',
    ];

    public function setMagicDescriptionAttribute($description)
    {
        $parser = DescriptionParserFactory::make($description);

        $this->attributes['description'] = $parser->getDescription();
        $this->attributes['quantity'] = $parser->getQuantity();
        $this->attributes['implicitQty'] = $parser->isImplicit();
    }

    public function getQuantityAttribute()
    {
        return $this->attributes['quantity'] ?? self::DEFAULT_QUANTITY;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function group()
    {
        return $this->belongsTo(GroceryListItemGroup::class, 'grocery_list_group_id');
    }

    public function getDepartmentNameAttribute()
    {
        return optional($this->department)->name;
    }

    public function toggleComplete()
    {
        return app(GroceryListItemRepository::class)->update([
            'is_checked' => (int)!$this->is_checked
        ], $this->getKey());
    }
}
