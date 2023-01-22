<?php

namespace App\Console\Commands;

use App\Models\Room;
use Illuminate\Console\Command;

class RoomSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roomsize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the room sizes based on the room types';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sizes = [
            'standard'=>2,
            'Superior'=>1,
            'Big Family Room' => 5,
            'Small Family Room' => 3
        ];

        foreach(Room::get() as $room) {
            $room->capacity = $sizes[$room->room_type];
            $room->save();
        }

        return Command::SUCCESS;
    }
}
