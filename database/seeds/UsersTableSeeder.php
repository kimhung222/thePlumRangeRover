<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        	['name' => 'Admin 1', 'email' => 'admin1@gmail.com', 'password' => bcrypt('admin1')],
        	['name' => 'Admin 2', 'email' => 'admin2@gmail.com', 'password' => bcrypt('admin2')]
        ];

        foreach($users as $user) {
        	User::create($user);
        }

    }
}
