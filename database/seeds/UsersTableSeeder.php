<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Dallin',
            'email' => 'dallinis@hotmail.com',
            'password' => bcrypt('coondog62')
        ]);

        factory(User::class)->create([
            'name' => 'Emily',
            'email' => 'emilylimabean@gmail.com',
            'password' => bcrypt('itsasunnyday2')
        ]);
    }
}
