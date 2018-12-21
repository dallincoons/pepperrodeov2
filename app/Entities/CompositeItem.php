<?php

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Spacegrass\Fraction;

class CompositeItem implements \Countable, Arrayable
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

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->items->first()->getKey(), //eventually change ow this works
            'grocery_list_id' => $this->items->first()->grocery_list_id,
            'department' => $this->items->first()->department_name,
            'quantity' => $this->quantity(),
            'description' => $this->items->first()->description,
        ];
    }
}
