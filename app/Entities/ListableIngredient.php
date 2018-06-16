<?php

namespace App\Entities;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
use Illuminate\Database\Eloquent\Model;

class ListableIngredient extends Model
{
    const DEFAULT_QUANTITY = 1;

    protected $casts = [
        'quantity' => 'string'
    ];

    protected $fillable = [
        'recipe_id',
        'full_description',
        'listable',
        'department_id'
    ];

    public function setQuantityAttribute($quantity)
    {
        $validString = empty($quantity) ? self::DEFAULT_QUANTITY : $quantity;

        $this->attributes['quantity'] = (string)fractionize($validString);
    }

    public function setFullDescriptionAttribute($description)
    {
        $parser = DescriptionParserFactory::make($description);

        $this->attributes['full_description'] = $description;
        $this->attributes['description'] = $parser->getDescription();
        $this->quantity = $parser->getQuantity();
    }
}
