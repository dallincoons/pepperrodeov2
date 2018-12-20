<?php

namespace App\Entities;

use Illuminate\Support\Collection;
use Spacegrass\Fraction;

class CompositeItem implements \Countable
{
    /**
     * @var Collection
     */
    protected $items;

    public function __construct(Collection $item)
    {
        $this->items = $item;
    }

    public function quantity()
    {
        return (string)$this->items->reduce(function (Fraction $original, $dupe) {
            return $original->add(fractionize($dupe->quantity));
        }, new Fraction(0));
    }

    public function count()
    {
        return count($this->items);
    }

    public function __get($value)
    {
        return $this->{$value}();
    }
}
