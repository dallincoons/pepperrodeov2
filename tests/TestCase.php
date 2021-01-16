<?php

namespace Tests;

use App\Entities\GroceryList;
use App\Exceptions\Handler;
use App\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Scout\ModelObserver;
use Tests\Fakers\GroceryListFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private $oldExceptionHandler;

    public function setUp()
    {
        parent::setUp();

        ModelObserver::disableSyncingFor(GroceryList::class);

        $this->disableExceptionHandling();

        $this->user = factory(User::class)->create();

        $this->be($this->user);
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function api(string $url)
    {
        return '/api/v1' . str_start($url, '/');
    }
}
