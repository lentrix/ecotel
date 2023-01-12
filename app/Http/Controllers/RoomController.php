<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index() {
        $rooms = Room::orderBy('name')->get();
        return view('rooms.index', [
            'rooms' => $rooms
        ]);
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'name' => 'string|required',
            'description' => 'string|required',
            'room_type' => 'string|required',
            'rate' => 'numeric|required',
        ]);

        Room::create($fields);

        return redirect('/rooms')->with('Info','A new room has been created.');
    }

    public function update(Request $request) {
        $request->validate([
            'id' => "numeric|required"
        ]);

        $room = Room::findOrFail($request->id);

        $room->update($request->all());

        return redirect('/rooms')->with('Info',"$room->name room has been updated.");
    }

    public function destroy(Request $request) {

        $room = Room::findOrFail($request->id);

        $name = $room->name;

        $room->delete();

        return redirect('/rooms')->with('Info',"$name room has been deleted.");

    }
}
