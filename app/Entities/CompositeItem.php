<?php

namespace App\Entities;

use App\Entities\Behavior\DescriptionParsers\DescriptionParserFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Spacegrass\Fraction;

class CompositeItem implements \Countable, Arrayable
{
    /**
     * @var Collection
     */
    protected $items;

    /**
     * @param Collection $item - collection of GroceryListItems
     */
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

    public function department()
    {
        return $this->items->first()->department_name;
    }

    public function departmentId()
    {
        return $this->items->first()->department->getKey();
    }

    public function description()
    {
        return $this->items->first()->description;
    }

    public function count()
    {
        return count($this->items);
    }

    //@todo add a unit of work approach to make this more efficient
    public function updateDepartment(int $departmentId)
    {
        $this->items->each(function (GroceryListItem $item) use ($departmentId) {
            $item->department_id = $departmentId;
            $item->save();
        });
    }

    //@todo add a unit of work approach to make this more efficient
    public function updateDescription(string $description)
    {
        $parser = DescriptionParserFactory::make($description);

        $this->items->each(function (GroceryListItem $item) use ($description, $parser) {
            $item->description = $parser->getDescription();
            $item->save();
        });

        $this->updateQuantity($parser->getQuantity());
    }

    /**
     * This probably isn't the right approach, so it can
     * act as a placeholder until something better
     *
     * @param int $quantity
     */
    public function updateQuantity(int $quantity)
    {
        $newQuantity = $quantity - $this->quantity();
        $item = $this->items->first();
        $item->quantity = $item->quantity + $newQuantity;
        $item->save();
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
            'ids' => $this->items->pluck('id'),
            'grocery_list_id' => $this->items->first()->grocery_list_id,
            'department' => $this->department(),
            'department_id' => $this->departmentId(),
            'quantity' => $this->quantity(),
            'description' => $this->items->first()->description,
        ];
    }
}
