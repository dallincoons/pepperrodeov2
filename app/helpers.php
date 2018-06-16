<?php

use Spacegrass\Fraction;

if (! function_exists('fractionize')) {
    /**
     * Normalize fraction and float string representations int a fraction object.
     *
     * @param  string|int|float  $qty
     */
    function fractionize($qty)
    {
        return Fraction::isFraction($qty) ? Fraction::fromString($qty) : Fraction::fromFloat((float)$qty);
    }
}
