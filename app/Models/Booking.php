<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    protected $fillable = ['check_in','check_out','source','room_id','room_rate','added_by','with_breakfast',
            'purpose','status','final_payment','final_pmt_mode','checkout_at'];

    public function getGuestAttribute() {
        $bookingGuest = BookingGuest::where('booking_id', $this->id)
                ->orderBy('created_at')
                ->first();
        return $bookingGuest ? $bookingGuest->guest : new Guest(['last_name'=>"none",'first_name'=>'none']);
    }

    public function getIsCancelledAttribute() {
        return substr($this->status,0,9)=="Cancelled";
    }

    public function getIsConfirmedAttribute() {
        return strcasecmp(substr($this->status,0,9), "Confirmed") == 0;
    }

    public function getIsCheckedOutAttribute() {
        return strcasecmp(substr($this->status,0,11), "Checked Out") == 0;
    }

    public function bookingGuests() {
        return $this->hasMany('App\Models\BookingGuest');
    }

    public function room() {
        return $this->belongsTo('App\Models\Room');
    }

    public function bookingAddons() {
        return $this->hasMany('App\Models\BookingAddon')->orderBy('created_at','asc');
    }

    public function getNightsAttribute() {
        $in = new Carbon($this->check_in->format('Y-m-d'));
        $out = new Carbon($this->check_out->format('Y-m-d'));

        return $out->diffInDays($in);
    }

    public function getRoomRentAttribute() {
        return $this->nights * $this->room_rate;
    }

    public function getAddonTotalAttribute() {
        return $this->bookingAddons->sum('amount');
    }

    public function getGrossTotalAttribute() {
        return $this->room_rent + $this->addonTotal;
    }

    // public function getVatAmountAttribute() {
    //     $gross = $this->grossTotal;

    //     $vatAmt = $gross - ($gross*(100/(112)));

    //     return $vatAmt;
    // }

    public static function currentBookings() {
        $now = Carbon::parse( date('Y-m-d') );
        $now->addMinutes(721);

        return static::where('check_in','<=',$now)
            ->where('check_out','>',$now)
            ->whereNot('status','LIKE',"Cancelled%")
            ->get();
    }

    public static function upComingBookings() {
        $now = Carbon::parse( date('Y-m-d') );
        $now->addMinutes(721);

        return static::where('check_in','>',$now)->get();
    }

    public function getTotalPayoutAttribute() {
        return ($this->room_rent + $this->addonTotal + $this->surcharge + $this->vat) - ($this->down_payment + $this->discount_amount + $this->final_payment);
    }

    public function getTotalBeforeVatAttribute() {
        return ($this->room_rent + $this->addonTotal + $this->surcharge) - ($this->down_payment + $this->discount_amount);
    }

    public function getSurchargeAttribute() {
        if($this->cc_surcharge_percent==0) {
            return 0;
        }

        if($this->cc_surcharge_portion=="down payment") {
            return $this->down_payment * ($this->cc_surcharge_percent/100);
        }

        if($this->cc_surcharge_portion=="balance") {
            $balance = ($this->room_rent + $this->addonTotal + $this->vat) - ($this->down_payment+$this->discount_amount);
            return $balance * ($this->cc_surcharge_percent/100);
        }

        if($this->cc_surcharge_portion=="total") {
            $total = ($this->room_rent + $this->addonTotal + $this->vat) - $this->discount_amount;
            return $total * ($this->cc_surcharge_percent/100);
        }
    }

    public function guestIsInBooking($guestId) {
        $gb = BookingGuest::where('guest_id', $guestId)
            ->where('booking_id', $this->id)->first();

        return $gb;
    }

    public function getCancelledAttribute() {
        return strcmp(substr($this->status, 0, 9), "Cancelled") == 0;
    }
}
