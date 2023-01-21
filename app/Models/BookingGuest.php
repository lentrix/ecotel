<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingGuest extends Model
{
    protected $fillable = ['guest_id','booking_id'];

    public function guest() {
        return $this->belongsTo('App\Models\Guest');
    }

    public function booking() {
        return $this->belongsTo('App\Models\Booking');
    }
}
