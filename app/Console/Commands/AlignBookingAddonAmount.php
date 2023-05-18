<?php

namespace App\Console\Commands;

use App\Models\BookingAddon;
use Illuminate\Console\Command;

class AlignBookingAddonAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'align:bookingaddon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for re-aligning the amount value of all booking addons with the current price of the addon it is referred by.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bas = BookingAddon::whereDoesntHave('addon', function($q){
            $q->where('name','Others');
        })->get();

        $count = 0;
        foreach($bas as $ba) {
            $ba->amount = $ba->addon->amount;
            $ba->save();
            $count++;
        }
        echo "Command finished. $count booking addons updated.\n";
        return Command::SUCCESS;
    }
}
