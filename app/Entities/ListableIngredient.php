<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Phospr\Fraction;

class ListableIngredient extends Model
{
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
        $validString = empty($quantity) ? 0 : $quantity;

        $this->attributes['quantity'] = Fraction::fromString($validString);
    }
}
