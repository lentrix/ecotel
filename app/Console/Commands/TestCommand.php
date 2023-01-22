<?php

namespace App\Console\Commands;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Date('Y-m-d');

        $room = Booking::where('check_in','<=', $date . ' 12:00')
        ->where('check_out','>', $date . ' 12:01')->get();

        dd($room);

        return Command::SUCCESS;
    }
}
