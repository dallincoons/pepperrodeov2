<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\Behavior\RegistersNewUser;
use Tests\TestCase;

class RegistersNewUserTest extends TestCase
{
    use RegistersNewUser;

    public function setUp()
    {
        parent::setUp();

        \Auth::logout();
        User::truncate();
    }

    /** @test */
    public function it_registers_new_user_successfully()
    {
        $response = $this->registerNew();

        $response->assertStatus(200);
        $this->assertEquals(1, User::count());
    }
}
