<?php

namespace App\Entities\Behavior\DescriptionParsers;

class NonNumericDescriptionParser extends DescriptionParser
{
    public function getDescription()
    {
        return $this->description;
    }

    public function getQuantity()
    {
        return 1;
    }
}
