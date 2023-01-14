<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request) {

        if(!$request->last_name && !$request->first_name){
            $remarks = "Recent Guests";
            $guests = Guest::leftJoin('bookings','bookings.guest_id','guests.id')
                ->orderBy('bookings.created_at','desc')
                ->select('guests.*')
                ->limit(50);
        }else {
            $remarks = "Search Results";

            $guests = Guest::orderBy('last_name')->orderBy('first_name');

            if($request->last_name) {
                $guests->where('last_name','like',"%$request->last_name%");
            }

            if($request->first_name) {
                $guests->where('first_name','like',"%$request->first_name%");
            }
        }

        return view('guests.index',[
            'remarks' => $remarks,
            'guests' => $guests->get(),
            'countries' => Country::pluck('name','nicename')
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'last_name' => 'string|required',
            'first_name' => 'string|required',
            'middle_name' => 'string|required'
        ]);

        $guest = Guest::create($request->all());

        return redirect('/guests/' . $guest->id)->with('Info','New guest has been added.');
    }

    public function show(Guest $guest) {

        return view('guests.view',[
            'guest' => $guest,
            'countries' => Country::pluck('name','nicename')
        ]);
    }

    public function update(Request $request, Guest $guest) {
        $guest->update($request->all());
        return redirect('/guests/' . $guest->id)->with('Info','This guest\'s profile has been updated.');
    }
}
