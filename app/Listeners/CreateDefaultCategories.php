<?php

namespace App\Listeners;

use Laravel\Spark\Events\Auth\UserRegistered;

class CreateDefaultCategories
{
    protected $defaultCategoryNames = [
        'Breakfast',
        'Lunch',
        'Dinner'
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        foreach($this->defaultCategoryNames as $name) {
            $user->categories()->create([
                'title' => $name,
            ]);
        }
    }
}
