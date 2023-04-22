<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\BookingGuest;
use App\Models\Guest;
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

        return redirect('/bookings/' . $booking->id)->with('Info','A guest has been added.');
    }

    public function removeGuest(Booking $booking, Request $request) {
        $request->validate([
            'guest_id' => 'numeric|required'
        ]);

        BookingGuest::where('booking_id',$booking->id)
            ->where('guest_id', $request->guest_id)
            ->delete();

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

        return back()->with('Info','This booking has been confirmed');
    }

    public function cancelBooking(Booking $booking) {
        $booking->status = "Cancelled by " . auth()->user()->uname;
        $booking->save();

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

        return back()->with('Info','The discount of this booking has been updated.');
    }

    public function addVat(Booking $booking) {
        $booking->vat = $booking->total_before_vat * 0.12;
        $booking->save();

        return redirect('/bookings/' . $booking->id)->with('Info','VAT has been added to this booking');
    }

    public function removeVat(Booking $booking) {
        $booking->vat = 0;
        $booking->save();

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

        return redirect('/bookings/' . $booking->id)->with('Info','This booking has been imposed with surcharges for credit card/debit card payment');
    }

    public function removeSurcharge(Booking $booking) {
        $booking->cc_surcharge_percent = 0;
        $booking->cc_surcharge_portion = null;
        $booking->save();

        return redirect('/bookings/'. $booking->id)->with('Info','The surcharge of this booking has been removed.');
    }

    public function toggleBooking(Booking $booking) {
        $booking->update([
            'with_breakfast' => !$booking->with_breakfast
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

        return redirect('/bookings')->with('Info',$msg);
    }
}
