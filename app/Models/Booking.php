<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['guest_id','check_in','check_out','room_id','room_rate','added_by'];

    public function guest() {
        return $this->belongsTo('App\Models\Guest');
    }

    public function room() {
        return $this->belongsTo('App\Models\Room');
    }
}
