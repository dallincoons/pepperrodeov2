<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Spacegrass\Fraction;

class ListableIngredient extends Model
{
    const DEFAULT_QUANTITY = 1;

    protected $casts = [
        'quantity' => 'string'
    ];

    protected $fillable = [
        'recipe_id',
        'quantity',
        'description',
        'listable',
        'department_id'
    ];

    public function setQuantityAttribute($quantity)
    {
        $validString = empty($quantity) ? self::DEFAULT_QUANTITY : $quantity;

        $this->attributes['quantity'] = Fraction::fromString($validString);
    }
}
