<?php

namespace Tests\Behavior;

use App\Entities\GroceryList;
use Laravel\Scout\ModelObserver;

trait EnablesSearchDriver
{
    /** @before */
    public function enabledSearch()
    {
        ModelObserver::enableSyncingFor(GroceryList::class);
    }

    /** @after */
    public function disableSearch()
    {
        ModelObserver::disableSyncingFor(GroceryList::class);
    }
}
