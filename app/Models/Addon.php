<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'addon_type', 'amount'];

    public static function dailyTotal($date, $type) {
        return BookingAddon::whereHas('addon', function($q1) use ($type) {
            $q1->where('addon_type', $type);
        })
        ->whereBetween('created_at',[$date . ' 00:00', $date . " 23:59:59"])
        ->sum('amount');
    }
}
