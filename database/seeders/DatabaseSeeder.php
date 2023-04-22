<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Booking;
use App\Models\Guest;
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
        // $this->run(UserSeeder::class);
        $rooms = [
            [
                'type'=>'Economy',
                'description' => 'Economy room with 1 bed and cable TV',
                'rate' => 800
            ],
            [
                'type' => 'Double',
                'description' => 'Standard room with two beds, air conditioning, and cable TV',
                'rate' => 1500
            ],
            [
                'type' => 'Standard',
                'description' => 'Standard single room with air-conditioning and cable TV',
                'rate' => 1200
            ],
            [
                'type' => 'Family Suite',
                'description' => 'Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV',
                'rate' => 2300
            ]
        ];

        foreach($rooms as $room) {
            for($i=1; $i<=6; $i++) {
                Room::create([
                    'name' => $room['type'] . " " . $i,
                    'description' => $room['description'],
                    'room_type' => $room['type'],
                    'rate' => $room['rate']
                ]);
            }
        }

        Guest::factory(50)->create();

        Booking::factory(100)->create();

    }
}
