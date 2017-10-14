<?php

namespace App\Macros\Collection;

class DuplicateItem
{
    public function duplicates()
    {
        return function ($field) {
            $plucked = $this->pluck($field);
            $unique = $plucked->unique();
            $duplicated = $plucked->diffAssoc($unique);

            $duplicateItems = $this->filter(function ($item) use ($duplicated, $field) {
                return in_array($item[$field], $duplicated->all());
            });

            return collect($duplicateItems);
        };
    }
}
