<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['last_name','first_name','middle_name','address','idno', 'country','phone','email','company','company_address','company_tin','added_by','ofw'];

    public function addedBy() {
        return $this->belongsTo('App\Models\User');
    }

    public function bookingGuests() {
        return $this->hasMany('App\Models\BookingGuest')->orderBy('created_at','desc');
    }

    public function getFullNameAttribute() {
        return $this->first_name . " " . substr($this->middle_name, 0,1) . ". " . $this->last_name;
    }

    public function getNoBookingAttribute() {
        return $this->bookingGuests->count()==0;
    }
}
