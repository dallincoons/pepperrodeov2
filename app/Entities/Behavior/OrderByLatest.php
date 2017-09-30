<?php

namespace App\Entities\Behavior;

use App\Scopes\OrderByLatest as OrderByLatestScope;

trait OrderByLatest
{
    public static function bootOrderByLatest()
    {
        static::addGlobalScope(new OrderByLatestScope);
    }
}
