<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'uname' => 'lentrix',
                'full_name' => 'Benjie B. Lenteria',
                'user_type' => 'admin',
                'password' => 'password123'
            ],
            [
                'uname' => 'mitch',
                'full_name' => 'Michelle H. Boromeo',
                'user_type' => 'user',
                'password' => 'password123'
            ]
        ];

        foreach($users as $user) User::create($user);
    }
}
