<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\Guest;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() {

        return view('bookings.index',[
            'currentBookings' => Booking::currentBookings(),
            'upComingBookings' => Booking::upComingBookings()
        ]);
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

        $checkIn = Carbon::parse($request->check_in . "12:01");
        $checkOut = Carbon::parse($request->check_out . "12:00");

        if($checkIn->isAfter($checkOut) || $checkIn->equalTo($checkOut)) {
            return back()->withInput()->with('Error','The date selection is invalid. The check out must be after the check in');
        }

        $rooms = Room::whereDoesntHave('bookings', function($q1) use ($checkIn, $checkOut){
            $q1->where(function($q2) use ($checkIn, $checkOut) {
                $q2->where('check_in','<=', $checkIn)
                    ->where('check_out','>=', $checkIn);
            })->orWhere(function($q3) use ($checkIn, $checkOut) {
                $q3->where('check_in','<=', $checkOut)
                ->where('check_out','>=', $checkOut);
            });
        })->orderBy('room_type')->orderBy('name');

        return view('bookings.create-page-2',[
            'guest' => $guest,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'rooms' => $rooms->get()
        ]);
    }

    public function create3(Request $request, Guest $guest) {
        return view('bookings.create-page-3',[
            'check_in' => new Carbon($request->check_in),
            'check_out' => new Carbon($request->check_out),
            'room' => Room::findOrFail($request->room_id),
            'guest' => $guest
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'guest_id' => 'numeric|required',
            'room_id' => 'numeric|required',
            'check_in' => 'string|required',
            'check_out' => 'string|required',
            'room_rate' => 'numeric|required'
        ]);

        $booking = Booking::create($request->all());

        return redirect('bookings/' . $booking->id)->with('Info','New booking created.');
    }

    public function show(Booking $booking) {
        $addons = Addon::orderBy('name')->get();
        return view('bookings.view',[
            'booking' => $booking,
            'addons' => $addons
        ]);
    }

    public function addAddonItem(Booking $booking, Request $request) {
        $request->validate([
            'addon_id' => 'numeric|required',
            'qty' => 'numeric|required',
        ]);

        $addon = Addon::findOrFail($request->addon_id);

        BookingAddon::create([
            'booking_id' => $booking->id,
            'addon_id' => $addon->id,
            'qty' => $request->qty,
            'amount' => $request->qty * $addon->amount,
            'added_by' => auth()->user()->id
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','An add-on has been added to this booking.');
    }

    public function removeAddonItem(Booking $booking, Request $request) {
        BookingAddon::where('booking_id', $booking->id)
            ->where('addon_id', $request->addon_id)->delete();
        return back()->with('Info','An Add-on has been removed from this booking');
    }
}
