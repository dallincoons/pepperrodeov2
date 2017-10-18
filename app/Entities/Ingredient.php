<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Phospr\Fraction;

class Ingredient extends Model
{
    protected $casts = [
        'quantity' => 'string'
    ];

    protected $fillable = [
        'recipe_id',
        'quantity',
        'description',
        'listable'
    ];

    public function toggleListable()
    {
        $this->listable = !$this->listable;

        return $this;
    }

    public function setQuantityAttribute($quantity)
    {
        $this->attributes['quantity'] = Fraction::fromString($quantity);
    }
}
