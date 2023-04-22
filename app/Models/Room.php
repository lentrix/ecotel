<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','rate','room_type','capacity'];

    public function bookings() {
        return $this->hasMany('App\Models\Booking');
    }

    public static function dailyTotal($date) {
        return Room::whereHas('bookings', function($q1) use ($date){
            $q1->where('check_in', '<=', $date . ' 12:01')
                ->where('check_out','>', $date . ' 12:00')
                ->where('status','like','Confirmed%');
        })->sum('rate');
    }

    public function getCurrentOccupancyAttribute() {
        $now = Carbon::parse( now() );
        $now->addMinutes(721);

        return Booking::where('check_in','<=',$now)
            ->where('check_out','>',$now)
            ->where('room_id', $this->id)
            ->whereNot('status','LIKE',"Cancelled%")
            ->first();
    }
}
