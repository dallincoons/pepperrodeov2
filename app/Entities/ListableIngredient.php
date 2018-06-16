<?php

namespace App\Entities;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
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

        $this->attributes['quantity'] = (string)fractionize($validString);
    }

    public function setDescriptionAttribute($description)
    {
        $parser = DescriptionParserFactory::make($description);

        $this->attributes['description'] = $parser->getDescription();
        $this->quantity = $parser->getQuantity();
    }
}
