<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() {

        return view('bookings.index');
    }

    public function create(Guest $guest) {

        return view('bookings.create',[
            'guest' => $guest
        ]);
    }

    public function create2(Request $request, Guest $guest) {
        $request->validate([
            'check_in' => 'date|required',
            'check_out' => 'date|required'
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        if($checkIn->isAfter($checkOut) || $checkIn->equalTo($checkOut)) {
            return back()->withInput()->with('Error','The date selection is invalid. The check out must be after the check in');
        }

        $rooms = Room::whereDoesntHave('bookings', function($q1) use ($checkIn, $checkOut){
            $q1->whereBetween('check_in',[$checkIn, $checkOut])
                ->orWhereBetween('check_out', [$checkIn, $checkOut]);
        })->orderBy('room_type')->orderBy('name');

        return view('bookings.create-page-2',[
            'guest' => $guest,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'rooms' => $rooms->get()
        ]);
    }

    public function create3(Request $request, Guest $guest) {
        dd($request->all());
    }
}
