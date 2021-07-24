<?php

namespace App\Macros\Collection;

class DuplicateItem
{
    public function duplicates()
    {
        return function ($field) {
            $plucked = $this->pluck($field)->map(function($p) {
                return strtolower($p);
             });
            $unique = $plucked->unique()->map(function($p) {
                return strtolower($p);
            });
            $duplicated = $plucked->diffAssoc($unique);

            $duplicateItems = $this->filter(function ($item) use ($duplicated, $field) {
                return in_array(strtolower($item[$field]), $duplicated->all());
            });

            return collect($duplicateItems);
        };
    }
}
