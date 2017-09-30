<?php

namespace Tests\Behavior;

trait EnablesSearchDriver
{
    /** @before */
    public function enabledSearch()
    {
        putenv('SCOUT_DRIVER=algolia');
    }

    /** @after */
    public function disableSearch()
    {
        putenv('SCOUT_DRIVER=null');
    }
}
