<?php

namespace App\Entities\Behavior\DescriptionParsers;

abstract class DescriptionParser
{
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string|null
     */
    protected $quantity;

    public function __construct($description, $quantity = null)
    {
        $this->description = $description;
        $this->quantity = $quantity;
    }

    abstract public function getDescription();
    abstract public function getQuantity();
}
