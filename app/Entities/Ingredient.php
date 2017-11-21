<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Phospr\Fraction;

class Ingredient extends Model
{
    protected $casts = [
        'quantity' => 'string',
    ];

    protected $fillable = [
        'recipe_id',
        'quantity',
        'description',
        'listable',
    ];

    public function setQuantityAttribute($quantity)
    {
        $this->attributes['quantity'] = Fraction::fromString($quantity);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
