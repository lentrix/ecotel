<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\BookingGuest;
use App\Models\Guest;
use App\Models\Log;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'check_out' => 'date|required',
            'source' => 'string|required',
            'purpose' => 'string|required'
        ]);

        $checkIn = Carbon::parse($request->check_in . "12:01");
        $checkOut = Carbon::parse($request->check_out . "12:00");


        $purpose = $request->purpose=="Others" ? $request->other_purpose : $request->purpose;
        $with_breakfast = $request->with_breakfast=="on" ? "Yes" : "No";

        if($checkIn->isAfter($checkOut) || $checkIn->equalTo($checkOut)) {
            return back()->withInput()->with('Error','The date selection is invalid. The check out must be after the check in');
        }

        $rooms = Room::whereDoesntHave('bookings', function($q1) use ($checkIn, $checkOut){
            $q1->where(function($q2) use ($checkIn, $checkOut) {
                    $q2->where('check_in','<=', $checkIn)
                    ->where('check_out','>=', $checkIn)
                    ->whereNot('status','like','Cancelled%');
            })->orWhere(function($q3) use ($checkIn, $checkOut) {
                    $q3->where('check_in','<=', $checkOut)
                    ->where('check_out','>=', $checkOut)
                    ->whereNot('status','like','Cancelled%');
            });
        })->orderBy('room_type')->orderBy('name');

        return view('bookings.create-page-2',[
            'guest' => $guest,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'source' => $request->source,
            'with_breakfast' => $with_breakfast,
            'purpose' => $purpose,
            'rooms' => $rooms->get()
        ]);
    }

    public function create3(Request $request, Guest $guest) {
        return view('bookings.create-page-3',[
            'check_in' => new Carbon($request->check_in),
            'check_out' => new Carbon($request->check_out),
            'room' => Room::findOrFail($request->room_id),
            'source' => $request->source,
            'purpose' => $request->purpose,
            'with_breakfast' => $request->with_breakfast,
            'guest' => $guest
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'guest_id' => 'numeric|required',
            'room_id' => 'numeric|required',
            'check_in' => 'string|required',
            'check_out' => 'string|required',
            'source' => 'string|required',
            'room_rate' => 'numeric|required',
            'purpose' => 'string|required',
        ]);

        if($confirmed = in_array($request->source,['Via Agoda','Via Booking.com'])) {
            $roomRate = 0;
        }else {
            $roomRate = $request->room_rate;
        }

        $booking = Booking::create([
            'guest_id' => $request->guest_id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'source' => $request->source,
            'room_rate' => $roomRate,
            'with_breakfast' => $request->with_breakfast,
            'purpose' => $request->purpose,
            'added_by' => $request->added_by,
            'status' => $confirmed ? "Confirmed by " . auth()->user()->uname : "pending"
        ]);

        BookingGuest::create([
            'guest_id' => $request->guest_id,
            'booking_id' => $booking->id
        ]);

        Log::create([
            'user_id'=>auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description'=>'Created booking'
        ]);

        return redirect('bookings/' . $booking->id)->with('Info','New booking created.');
    }

    public function show(Booking $booking) {
        $addons = Addon::orderBy('name')->get();

        return view('bookings.view',[
            'booking' => $booking,
            'addons' => $addons,
        ]);
    }

    public function addAddonItem(Booking $booking, Request $request) {
        $request->validate([
            'addon_id' => 'numeric|required',
            'qty' => 'numeric|required',
        ]);

        $addon = Addon::findOrFail($request->addon_id);

        $bookingAddon = BookingAddon::create([
            'booking_id' => $booking->id,
            'addon_id' => $addon->id,
            'qty' => $request->qty,
            'amount' => $request->qty * $addon->amount,
            'added_by' => auth()->user()->id
        ]);

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $bookingAddon->booking_id,
            'description' => "Addon added ($addon->name amounting to $bookingAddon->amount)"
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','An add-on has been added to this booking.');
    }

    public function addCustomAddonItem(Booking $booking, Request $request) {
        $request->validate([
            'remarks' => 'string|required',
            'qty' => 'numeric|required',
            'amount' => 'numeric|required',
        ]);

        //create or retrieve others addon
        $others = Addon::where('name','Others')->first();
        if(!$others) {
            $others = Addon::create([
                'name' => 'Others',
                'description' => 'Custom Addon',
                'addon_typ' => 'others',
                'amount' => 0
            ]);
        }

        BookingAddon::create([
            'booking_id' => $booking->id,
            'addon_id' => $others->id,
            'qty' => $request->qty,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'added_by' => auth()->user()->id,
        ]);

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Created the booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','A custom addon has been added.');
    }

    public function removeAddonItem(Booking $booking, Request $request) {
        $bookingAddon = BookingAddon::where('booking_id', $booking->id)
            ->where('addon_id', $request->addon_id)->first();

        $addStr = $bookingAddon->qty . " " . $bookingAddon->addon->name . " amounting to " . $bookingAddon->amount;

        BookingAddon::where('booking_id', $booking->id)
            ->where('addon_id', $request->addon_id)->delete();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Removed addon (" . $addStr . ") from booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return back()->with('Info','An Add-on has been removed from this booking');
    }

    public function addGuest(Request $request, Booking $booking) {
        $request->validate([
            'guest_id' => 'numeric|required',
        ]);

        if($booking->guestIsInBooking($request->guest_id)){
            return back()->with('Info','The guest is already in the booking.');
        }

        BookingGuest::create([
            'booking_id' => $booking->id,
            'guest_id' => $request->guest_id
        ]);

        $guest = Guest::find($request->guest_id);

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Guest $guest->full_name added to booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','A guest has been added.');
    }

    public function removeGuest(Booking $booking, Request $request) {
        $request->validate([
            'guest_id' => 'numeric|required'
        ]);

        $bookingGuest = BookingGuest::where('booking_id',$booking->id)
            ->where('guest_id', $request->guest_id)->first();

        BookingGuest::where('booking_id',$booking->id)
            ->where('guest_id', $request->guest_id)
            ->delete();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Guest " . $bookingGuest->guest->full_name . " is removed from booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return back()->with('Info','A guest has been removed from this booking.');
    }

    public function confirmBooking(Booking $booking, Request $request) {
        $request->validate([
            'down_payment'=>'numeric|required',
            'payment_mode'=>'string|required'
        ]);

        $booking->down_payment = $request->down_payment;
        $booking->payment_mode = $request->payment_mode;
        $booking->status = "confirmed by " . auth()->user()->uname;
        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Confirmed booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return back()->with('Info','This booking has been confirmed');
    }

    public function cancelBooking(Booking $booking) {
        $booking->status = "Cancelled by " . auth()->user()->uname;
        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Cancelled booking of " .$booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return back()->with('Info','This booking has been cancelled');
    }

    public function guestRecords(Booking $booking) {

        $pdf = Pdf::loadView('bookings.guest-records',[
            'booking' => $booking
        ]);

        if($booking->bookingGuests->count()>=5) {
            $pdf->setPaper('legal','portrait');
        }

        return $pdf->stream();

        // return view('bookings.guest-records',[
        //     'booking' => $booking
        // ]);
    }

    public function billingDetails(Booking $booking) {

        $pdf = Pdf::loadView('bookings.billing-details',[
            'booking' => $booking
        ]);

        return $pdf->stream();
    }

    public function updateDiscount(Booking $booking, Request $request) {

        if($request->discount_remarks) {
            $booking->discount_remarks = $request->discount_remarks;
            $booking->discount_amount = $request->discount_amount;
        }else{
            $booking->discount_remarks = null;
            $booking->discount_amount = null;
        }

        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Updated discount on booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y') . " to " . $booking->discount_amount
        ]);

        return back()->with('Info','The discount of this booking has been updated.');
    }

    public function addVat(Booking $booking, Request $request) {

        $booking->vat = $request->room_only ? ($booking->room_rent-$booking->down_payment) * 0.12 : $booking->total_before_vat * 0.12;
        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Added VAT to booking of " .$booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','VAT has been added to this booking');
    }

    public function removeVat(Booking $booking) {
        $booking->vat = 0;
        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Removed VAT from booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','VAT has been removed from this booking');
    }

    public function addSurcharge(Booking $booking, Request $request) {
        $request->validate([
            'portion' => 'string|required',
            'percent' => 'numeric|required'
        ]);

        $booking->cc_surcharge_percent = $request->percent;
        $booking->cc_surcharge_portion = $request->portion;
        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Added Surcharge to booking of " .$booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','This booking has been imposed with surcharges for credit card/debit card payment');
    }

    public function removeSurcharge(Booking $booking) {
        $booking->cc_surcharge_percent = 0;
        $booking->cc_surcharge_portion = null;
        $booking->save();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Removed Surcharge from booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/'. $booking->id)->with('Info','The surcharge of this booking has been removed.');
    }

    public function toggleBooking(Booking $booking) {
        $booking->update([
            'with_breakfast' => !$booking->with_breakfast
        ]);

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => ($booking->with_breakfast ? "Added breakfast to" : "Removed breakfast from") . " booking of " .
                    $booking->guest->full_name . " dated "
                    . $booking->check_in->format('M d, Y') . " to "
                    . $booking->check_out->format('M d, Y')
        ]);

        return back()->with('Info','Breakfast inclusion has been updated.');
    }

    public function destroy(Booking $booking) {

        if(!$booking->cancelled) return back()->with('Error','Only cancelled bookings are allowed to be deleted.');

        $msg = "The booking of " . $booking->guest->fullName . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y') . " has been deleted.";

        // $booking->bookingGuests->delete();
        BookingGuest::where('booking_id', $booking->id)->delete();
        // $booking->bookingAddons->delete();
        BookingAddon::where('booking_id', $booking->id)->delete();
        $booking->delete();

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => 0,
            'description' => $msg
        ]);

        return redirect('/bookings')->with('Info',$msg);
    }

    public function edit(Booking $booking) {
        return view('bookings.edit',[
            'booking' => $booking,
            'rooms' => Room::orderBy('name')->pluck('name','id')
        ]);
    }

    public function update(Booking $booking, Request $request) {
        $request->validate([
            'check_in' => 'date|required',
            'check_out' => 'date|required',
            'source' => 'string|required',
            'purpose' => 'string|required',
        ]);

        //check availability

        $checkIn = Carbon::parse($request->check_in . "12:01");
        $checkOut = Carbon::parse($request->check_out . "12:00");

        $otherBookings = Booking::where('room_id', $request->room_id)
            ->where(function($q) use ($checkIn, $checkOut){
                $q->whereBetween('check_in',[$checkIn, $checkOut])
                    ->orWhereBetween('check_out',[$checkIn, $checkOut]);
            })
            ->whereNot('id', $booking->id)
            ->first();

        if($otherBookings) {
            return back()->with('Error',"Booking changes will conflict with another booking by <a href='"
                    . url('/bookings/' . $otherBookings->id) ."' class='font-bold'>"
                    . $otherBookings->guest->full_name . "</a>.");
        }

        $room = Room::find($request->room_id);

        $booking->update([
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'source' => $request->source,
            'purpose' => $request->purpose,
            'room_rate' => $room->rate
        ]);

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Updated the booking of " . $booking->guest->full_name . " dated "
                . $booking->check_in->format('M d, Y') . " to "
                . $booking->check_out->format('M d, Y')
        ]);

        return redirect('/bookings/' . $booking->id)->with('Info','This booking has been updated.');
    }

    public function checkout(Booking $booking, Request $request) {
        $request->validate([
            'final_payment' => 'numeric|required',
            'final_pmt_mode' => 'string|required',
        ]);

        $booking->update([
            'final_payment' => $request->final_payment,
            'final_pmt_mode' => $request->final_pmt_mode,
            'checkout_at' => $request->checkout_at,
            'status' => 'Checked out by ' . auth()->user()->uname
        ]);

        Log::create([
            'user_id' => auth()->user()->id,
            'table' => 'bookings',
            'ref_no' => $booking->id,
            'description' => "Checked out booking of " . $booking->guest->full_name . " dated "
            . $booking->check_in->format('M d, Y') . " to "
            . $booking->check_out->format('M d, Y')
        ]);

        return back()->with('Info','This booking has been checked out.');
    }
}
