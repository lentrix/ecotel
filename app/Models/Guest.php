<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['last_name','first_name','middle_name','address','country','phone','email','company','company_address','company_tin','added_by'];

    public function addedBy() {
        return $this->belongsTo('App\Models\User');
    }

    public function bookings() {
        return $this->hasMany('App\Models\Booking');
    }

    public function getFullNameAttribute() {
        return $this->first_name . " " . substr($this->middle_name, 0,1) . ". " . $this->last_name;
    }
}
