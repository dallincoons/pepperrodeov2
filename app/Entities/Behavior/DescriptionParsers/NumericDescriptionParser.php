<?php

namespace App\Entities\Behavior\DescriptionParsers;

class NumericDescriptionParser extends DescriptionParser
{
    public function getDescription()
    {
        return trim(str_after($this->description, $this->quantity));
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
