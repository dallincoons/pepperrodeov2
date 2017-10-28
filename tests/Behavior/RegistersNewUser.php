<?php

namespace Tests\Behavior;

trait RegistersNewUser
{
    public function registerNew()
    {
        return $this->post('/register', [
            'address' => "",
            'name' => 'Dallin Coons',
            'email' => 'dallinis@hotmail.com',
            'password' => 'coondog62',
            'password_confirmation' => 'coondog62',
            'terms' => true
        ]);
    }
}
