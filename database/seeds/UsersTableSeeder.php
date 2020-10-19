<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        if( ! User::where('email', 'dallinis@hotmail.com')->exists()) {
            factory(User::class)->create([
                'name'     => 'Dallin',
                'email'    => 'dallinis@hotmail.com',
                'password' => bcrypt('abc123')
            ]);
        }

        if( ! User::where('email', 'emilylimabean@gmail.com')->exists()) {
            factory(User::class)->create([
                'name'     => 'Emily',
                'email'    => 'emilylimabean@gmail.com',
                'password' => bcrypt('abc123')
            ]);
        }
    }
}
