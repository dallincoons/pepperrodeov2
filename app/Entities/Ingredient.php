<?php

namespace App\Entities;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
use Illuminate\Database\Eloquent\Model;
use Spacegrass\Fraction;

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
        $this->attributes['quantity'] = fractionize($quantity);
    }

    public function setDescriptionAttribute($description)
    {
        $parser = DescriptionParserFactory::make($description);

        $this->attributes['description'] = $parser->getDescription();
        $this->quantity = $parser->getQuantity();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
