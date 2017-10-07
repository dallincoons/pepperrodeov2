<?php

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;

trait LogsIn
{
    /** @before */
    public function logIn()
    {
        $user = factory(User::class)->create([
            'email' => 'dallinis@hotmail.com',
            'password' => bcrypt('1234')
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText('My Grocery Lists');
        });
    }
}
