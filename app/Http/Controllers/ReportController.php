<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index() {

        $addonTypes = config('ecotel.addon_types');
        $addonTypes['Room'] = 'Room';

        return view('reports.index',[
            'addonTypes' => $addonTypes
        ]);
    }

    public function dailySummary(Request $request) {
        $date = Carbon::parse($request->date);
        $date->addMinutes(721);

        $bookings = Booking::where('check_in', '<=', $date)
            ->where('check_out','>=', $date)->get();

        $pdf = Pdf::loadView('/reports/daily-summary',[
            'bookings' => $bookings,
            'date' => $date
        ]);

        return $pdf->stream();
    }

    public function dailyIncome(Request $request) {

        if($request->addon_type=="Room") {

            $now = Carbon::parse($request->date);
            $now->addMinutes(721);

            $data = Booking::where('check_in','<=',$now)
                    ->where('check_out','>',$now)
                    ->where('status','like','Confirmed%')
                    ->join('rooms','room_id','rooms.id')
                    ->select(DB::raw('rooms.name AS "name", "1" AS "qty_sum", bookings.room_rate AS "amount_sum"'))
                    ->get();

        }else {

            $data = BookingAddon::whereBetween('booking_addons.created_at',[$request->date . ' 00:00', $request->date . " 23:59:59"])
                ->whereHas('addon', function($q1) use ($request){
                    $q1->where('addon_type', $request->addon_type);
                })->whereHas('booking', function($q2){
                    $q2->where('status','like','Confirmed%');
                })
                ->join('addons','addon_id','addons.id')
                ->groupBy('addons.name')
                ->select(DB::raw('addons.name AS "name", SUM(qty) AS qty_sum, SUM(booking_addons.amount) AS amount_sum'))
                ->get();
        }

        $pdf = Pdf::loadView('/reports/daily-income',[
            'addon_type' => $request->addon_type,
            'data' => $data,
            'date' => Carbon::parse($request->date)
        ]);

        $pdf->setPaper([0,0,612,936],'portrait');

        return $pdf->stream();

    }

    public function periodicIncome(Request $request) {
        $dFrom = Carbon::parse($request->date_from);
        $dTo = Carbon::parse($request->date_to);

        $dt = $dFrom;

        $data = [];

        $total = 0;

        while($dt <= $dTo) {
            $day = $dt->format('Y-m-d');
            $room = Room::dailyTotal($day);
            $food = Addon::dailyTotal($day, 'Food');
            $beverage = Addon::dailyTotal($day, 'Beverage');
            $amenity = Addon::dailyTotal($day, 'Amenity');
            $surcharges = Addon::dailyTotal($day, 'surcharges');

            $subTotal = $room+$food+$beverage+$amenity+$surcharges;

            $data[$day] = [
                'room' => $room,
                'food' => $food,
                'beverage' => $beverage,
                'amenity' => $amenity,
                'surcharges' => $surcharges,
                'sub_total' => $subTotal
            ];

            $total += $subTotal;

            $dt->addDay();
        }

        $pdf = Pdf::loadView('/reports/periodic-report',[
            'date_from' => Carbon::parse($request->date_from),
            'date_to' => Carbon::parse($request->date_to),
            'data' => $data,
            'total' => $total
        ]);

        $pdf->setPaper([0,0,612,936],'portrait');

        return $pdf->stream();
    }
}
