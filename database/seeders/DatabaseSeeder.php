<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        $rooms = [
            [
                'name' => 'Economy 1',
                'description' => 'Economy Room with Aircon',
                'rate' => 1200,
                'room_type' => 'economy'
            ],
            [
                'name' => 'Economy 2',
                'description' => 'Economy Room with Aircon',
                'rate' => 1200,
                'room_type' => 'economy'
            ],
            [
                'name' => 'Family Suite 1',
                'description' => 'Family-size room for 5 pax with aircon',
                'rate' => 4100,
                'room_type' => 'family'
            ],
        ];

        foreach($rooms as $room) Room::create($room);

    }
}
