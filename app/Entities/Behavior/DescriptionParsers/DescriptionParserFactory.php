<?php

namespace App\Entities\Behavior\DescriptionParsers;

class DescriptionParserFactory
{
    public static function make($description): DescriptionParser
    {
        preg_match('/[^\s]+/', $description, $matches);

        if (isset($matches[0]) && is_numeric($matches[0])) {
            return new NumericDescriptionParser($description, false, $matches[0]);
        }

        return new NonNumericDescriptionParser($description, true);
    }
}
