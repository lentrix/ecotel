<?php

namespace Database\Factories;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $checkIn = new Carbon(fake()->dateTimeThisMonth());
        $checkOut = new Carbon($checkIn->format('Y-m-d'));
        $checkOut->addDays(2);

        $room = Room::find(fake()->numberBetween(1,24));

        return [
            'guest_id' => fake()->numberBetween(1,50),
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_id' => $room->id,
            'room_rate' => $room->rate,
            'added_by' => 1
        ];
    }
}
