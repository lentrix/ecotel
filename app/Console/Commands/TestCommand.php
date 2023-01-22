<?php

namespace App\Console\Commands;

use App\Models\Addon;
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
        $date = '2023-01-21';
        echo "Date: " . $date . "\n";
        echo "Room: " . Room::dailyTotal($date) . "\n";
        echo "Food: " . Addon::dailyTotal($date, 'Food') . "\n";
        echo "Beverage: " . Addon::dailyTotal($date, 'Beverage') . "\n";
        echo "Amenity: " . Addon::dailyTotal($date, 'Amenity') . "\n";
        echo "Surcharge: " . Addon::dailyTotal($date, 'surcharges') . "\n";

        return Command::SUCCESS;
    }
}
