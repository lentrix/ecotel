@extends('pdf-base',[
    'title' => "Report: Daily Booking Summary"
])

@section('content')

    <table width="100%">
        <tr>
            <td width="50%">
                <img src="images/banner.jpg" alt="Logo" style="height: 80px" >
            </td>
            <td width="50%" style="text-align: right">
                <h1 style="margin: 0px">Daily Booking Summary</h1>
                <i>{{ $date->format('F d, Y g:i') }}</i>
            </td>
        </tr>
    </table>

    <hr>

    <table class="table bordered" >
        <thead>
            <tr>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Guest</th>
                <th>Booking Source</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{$booking->check_in->format('M-d-Y')}}</td>
                <td>{{$booking->check_out->format('M-d-Y')}}</td>
                <td>({{ $booking->bookingGuests->count() }}) {{$booking->guest->full_name}}</td>
                <td>{{$booking->source}}</td>
                <td>{{$booking->status}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
