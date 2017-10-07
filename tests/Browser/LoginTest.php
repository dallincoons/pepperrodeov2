<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    /**
     * @test
     */
    public function logInAsUser()
    {
        factory(User::class)->create([
            'email' => 'dallinis@hotmail.com',
            'password' => bcrypt('1234')
        ]);

        $this->browse(function (Browser $browser) {

            $browser->visit('/');
            $browser->type('email', 'dallinis@hotmail.com');
            $browser->type('password', '1234');
            $browser->press('login_submit');

            $browser->assertSee('My Grocery Lists');
        });
    }
}
