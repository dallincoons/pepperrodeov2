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

    protected $isImplicit;

    public function __construct($description, bool $isImplicit = false, $quantity = null)
    {
        $this->description = $description;
        $this->isImplicit = $isImplicit;
        $this->quantity = $quantity;
    }

    abstract public function getDescription();
    abstract public function getQuantity();

    public function isImplicit()
    {
        return $this->isImplicit;
    }
}
