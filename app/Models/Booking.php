<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    protected $fillable = ['guest_id','check_in','check_out','room_id','room_rate','added_by'];

    public function guest() {
        return $this->belongsTo('App\Models\Guest');
    }

    public function room() {
        return $this->belongsTo('App\Models\Room');
    }

    public function bookingAddons() {
        return $this->hasMany('App\Models\BookingAddon')->orderBy('created_at','asc');
    }

    public function getNightsAttribute() {
        $in = new Carbon($this->check_in->format('Y-m-d'));
        $out = new Carbon($this->check_out->format('Y-m-d'));

        return $out->diffInDays($in);
    }

    public function getRoomRentAttribute() {
        return $this->nights * $this->room_rate;
    }

    public function getAddonTotalAttribute() {
        return $this->bookingAddons->sum('amount');
    }

    public static function currentBookings() {
        return static::where('check_in','<=',now())
            ->where('check_out','>=',now())->get();
    }

    public static function upComingBookings() {
        return static::where('check_in','>',now())->get();
    }
}
