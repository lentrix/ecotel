<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class Tester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:bookings {in} {out}';

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
        // $checkIn = '2023-01-07 12:01';
        // $checkOut = '2023-01-12 12:00';

        $checkIn = $this->argument('in');
        $checkOut = $this->argument('out');

        echo $checkIn . "->" . $checkOut . "\n\n";

        $bookings = Booking::where(function($q1) use ($checkIn, $checkOut){
            $q1->where('check_in','<=', $checkIn)
                ->where('check_out','>=', $checkIn);
        })->orWhere(function($q2) use ($checkIn, $checkOut) {
            $q2->where('check_in','<=', $checkOut)
                ->where('check_out','>=', $checkOut);
        });

        $others = Booking::whereNotIn('id', $bookings->get('id'));

        foreach($bookings->get() as $b) {
            echo $b->room->name . " " . $b->check_in . " - " . $b->check_out . "\n";
        }

        echo "\n=============================\n\n";

        foreach($others->get() as $ot) {
            echo $ot->room->name . " " . $ot->check_in . " - " . $ot->check_out . "\n";
        }

        return Command::SUCCESS;
    }
}
