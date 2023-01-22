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

        $bookingAddons = BookingAddon::whereBetween('created_at',[$request->date . ' 00:00', $request->date . " 23:59:59"])
            ->whereHas('addon', function($q1) use ($request){
                $q1->where('addon_type', $request->addon_type);
            })
            ->orderBy('created_at')->groupBy('addon_id')
            ->select(DB::raw('addon_id, SUM(qty) AS qty_sum, SUM(amount) AS amount_sum'))
            ->get();


        $pdf = Pdf::loadView('/reports/daily-income',[
            'addon_type' => $request->addon_type,
            'bookingAddons' => $bookingAddons,
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
