<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingGuest;
use App\Models\Guest;
use App\Models\Log;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home() {

        $now = Carbon::parse( date('Y-m-d') );
        $now->addMinutes(721);

        $rooms = Room::count();
        $current = Booking::currentBookings()->count();
        $occupancy = number_format(($current/$rooms)*100) . "%";

        $checkInToday = Booking::whereDate('check_in', date('Y-m-d'))->count();
        $checkOutToday = Booking::whereDate('check_out', date('Y-m-d'))->count();

        $occupiedRooms = Room::whereHas('bookings', function($q1) use($now) {
            $q1->where('check_in','<=',$now)
            ->where('check_out','>',$now)
            ->where('status','like','Confirmed%');
        })->count();

        $currentGuests = BookingGuest::whereHas('booking', function($q) use($now) {
            $q->where('check_in','<=',$now)
                ->where('check_out','>',$now)
                ->where('status','like','Confirmed%');
        })->count();


        return view('home',[
            'numberOfGuests' => Guest::count(),
            'currentBookings' => $current,
            'upComingBookings' => Booking::upComingBookings()->count(),
            'addOns' => Addon::count(),
            'rooms' => $rooms,
            'occupiedRooms' => $occupiedRooms,
            'occupancy' => $occupancy,
            'currentGuests' => $currentGuests,
            'checkInToday' => $checkInToday,
            'checkOutToday' => $checkOutToday,
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'uname' => 'string|required',
            'password' => 'string|required',
        ]);

        $user = User::where('uname', $request->uname)->first();

        if(!$user) {
            return back()->with('Error','Sorry! User name ' . $request->user . ' is not found.');
        }

        if(!$user->active) {
            return back()->with('Error','Sorry your user account is INACTIVE. Please contact the systems administrator to activate your account.');
        }

        $user = auth()->attempt($request->only('uname','password'));

        if(!$user) {
            return back()->with('Error','Invalid user credentials');
        }

        return redirect('/home');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function logsView(Request $request) {
        $logs = Log::orderBy('created_at','desc');

        if($request->user_id) {
            $logs->where('user_id', $request->user_id);
        }

        if($request->date_from && $request->date_to) {
            $logs->whereBetween('created_at',[$request->date_from, $request->date_to]);
        }

        return view('logs',[
            'users' => User::orderBy('full_name')->pluck('full_name','id'),
            'logs'=>$logs->limit(100)->get(),
            'request' => $request
        ]);
    }
}
