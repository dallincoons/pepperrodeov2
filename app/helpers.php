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

if (! function_exists('create')) {
    /**
     * @param string $modelClass
     * @param array $overrides
     * @return mixed
     */
    function create(string $modelClass, array $overrides = [])
    {
        return factory($modelClass)->create($overrides);
    }
}

if (! function_exists('make')) {
    /**
     * @param string $modelClass
     * @param array $overrides
     * @return mixed
     */
    function make(string $modelClass, array $overrides = [])
    {
        return factory($modelClass)->make($overrides);
    }
}
