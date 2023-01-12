<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAddon extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id','addon_id','amount','remarks','added_by'];

    public function booking() {
        return $this->belongsTo('App\Models\Booking');
    }

    public function addOn() {
        return $this->belongsTo('App\Models\Addon');
    }

    public function addedBy() {
        return $this->belongsTo('App\Models\User');
    }
}
