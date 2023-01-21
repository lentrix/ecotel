<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index() {

        return view('reports.index');
    }

    public function dailySummary(Request $request) {
        $date = Carbon::parse($request->date);
        $date->addMinutes(721);

        $bookings = Booking::where('check_in', '<=', $date)
            ->where('check_out','>=', $date)->get();

        // return view('/reports/daily-summary',[
        //     'bookings' => $bookings,
        //     'date' => $date
        // ]);

        $pdf = Pdf::loadView('/reports/daily-summary',[
            'bookings' => $bookings,
            'date' => $date
        ]);

        return $pdf->stream();
    }
}
