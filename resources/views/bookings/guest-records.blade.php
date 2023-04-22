@extends("pdf-base",['title'=>'Guest Records'])

@section('content')

<table width="100%">
    <tr>
        <td width="50%">
            <img src="images/banner.jpg" alt="Logo" style="height: 80px" >
        </td>
        <td width="50%" style="text-align: right">
            <h1 style="margin: 0px">Guest Records</h1>
            <div>
                {{$booking->guest->full_name}}
                @if($booking->bookingGuests->count()>1) et. al. @endif
                at {{ $booking->room->name }}
            </div>
        </td>
    </tr>
</table>

@foreach($booking->bookingGuests as $index=>$bg)

<div style="padding: 8px; border: 1px solid black; margin-bottom: 8px">
    @if($booking->bookingGuests->count()>1)
        <div style="margin-bottom: 8px; font-weight: bold; font-size: 1.2em">Guest # {{ ($index+1) }}</div>
    @endif

    <div>
        <b>First Name:</b> <u>{{$bg->guest->first_name}}</u> &nbsp;&nbsp;
        <b>Last Name:</b> <u>{{$bg->guest->last_name}}</u> &nbsp;&nbsp;
    </div>
    <div>
        <b>Company Name: </b> <u>{{$bg->guest->company}}</u>
    </div>
    <div>
        <b>Company Address:</b> <u>{{$bg->guest->company_address}}</u>
    </div>
    <div>
        <b>Telephone Number:</b> <u>{{$bg->guest->phone}}</u> &nbsp;&nbsp;
        <b>Email Address:</b> <u>{{$bg->guest->email}}</u> &nbsp;&nbsp;
    </div>
    <div>
        <b>Passport/ID No.:</b> <u>{{$bg->guest->idno}}</u> &nbsp;&nbsp;
        <b>OFW?:</b> <u>{{ $bg->guest->ofw ? "Yes" : "No" }}</u> &nbsp;&nbsp;
    </div>
    <div>
        <b>Country of Residence:</b> <u>{{$bg->guest->country}}</u> &nbsp;&nbsp;
    </div>
    <div style="padding-top:24px">
        <b>Guest's Signature:</b> <div style="min-width: 300px; border-bottom: 1px solid black; display: inline-block"></div>
    </div>
</div>

@endforeach

<div style="border: 1px solid black; padding: 8px; ">
    <div>
        <b>Check In Date: </b> {{$booking->check_in->format('F d, Y')}} &nbsp;&nbsp;
        <b>Check Out Date: </b> {{$booking->check_out->format('F d, Y')}} &nbsp;&nbsp;
        <b>Total Nights: </b> {{$booking->nights}} &nbsp;&nbsp;
        <b># of Guests: </b> {{$booking->bookingGuests->count()}} &nbsp;&nbsp;
    </div>
    <div>
        <b>Room Type: </b> {{$booking->room->room_type}} &nbsp;&nbsp;
        <b>Room Name: </b> {{$booking->room->name}} &nbsp;&nbsp;
        <b>Room Rate: </b> {{$booking->room_rate}} &nbsp;&nbsp;
    </div>
    <div>
        <b>Purpose of undertaking: </b> {{$booking->purpose}} &nbsp;&nbsp;
        <b>With breakfast?: </b> {{$booking->with_breakfast ? "Yes" : "No"}} &nbsp;&nbsp;
        <b>Total Due (Room): </b> {{number_format($booking->room_rent, 2)}} &nbsp;&nbsp;
    </div>
    <div>
        <b>Booking Status: </b> {{$booking->status}} &nbsp;&nbsp;
        <b>Amount of deposit: </b> {{number_format($booking->down_payment,2)}} &nbsp;&nbsp;
        <b>Mode of Payment: </b> {{ $booking->payment_mode ? $booking->payment_mode : "N/A" }} &nbsp;&nbsp;
    </div>
</div>

<div style="margin-top: 24px">
    <b>Processed by: </b> <u>&nbsp;&nbsp;{{ auth()->user()->full_name }}&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;
    <b>Date: </b> <u>&nbsp;&nbsp;{{ date('F d, Y') }}&nbsp;&nbsp;</u>
</div>

@endsection
