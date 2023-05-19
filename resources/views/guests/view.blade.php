@extends('base')

@section('content')

@include('guests._edit-guest-modal')
@include('guests._delete-guest-modal',['guest'=>$guest])

<div class="heading-bar">
    <h1 class="title">Guest: {{$guest->full_name}}</h1>
    <div class="flex space-x-4">
        @if($guest->noBooking)
            <button class="danger" id="delete-guest-button">
                <i class="fa fa-trash"></i> Delete Guest
            </button>
        @endif
        <button class="secondary" type="button" id="editGuestButton">
            <i class="fa fa-edit"></i> Edit Guest Profile
        </button>
        <a href="{{url('/bookings/create/' . $guest->id)}}" class="primary">
            <i class="fa fa-file-alt"></i> Book this guest
        </a>
    </div>
</div>

<div class="flex space-x-4 mt-4">

    <div class="w-1/2 bg-green-100 rounded-md p-4">
        <h2 class="text-2xl">Personal Profile</h2>

        <table class="w-full">
            <tr>
                <th class="bg-green-800 text-green-100 text-md">Name</th>
                <td>
                    {{$guest->first_name}}
                    {{$guest->middle_name=="-" ? "" : $guest->middle_name}}
                    {{$guest->last_name}}
                </td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100">Address</th>
                <td>{{$guest->address}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100">Phone</th>
                <td>{{$guest->phone}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100">Email</th>
                <td>{{$guest->email}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100">Passport No/ID No.:</th>
                <td>{{$guest->idno}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100">OFW</th>
                <td>{{$guest->ofw ? "Yes" : "No"}}</td>
            </tr>
        </table>
    </div>

    <div class="w-1/2 bg-green-100 rounded-md p-4">
        <h2 class="text-2xl">Company Profile</h2>

        <table class="w-full">
            <tr>
                <th class="bg-green-800 text-green-100 text-md">Company Name</th>
                <td>{{$guest->company}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100">Company Address</th>
                <td>{{$guest->company_address}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100 text-md">Company TIN</th>
                <td>{{$guest->company_tin}}</td>
            </tr>
            <tr>
                <th class="bg-green-800 text-green-100 text-md">Country</th>
                <td>{{$guest->country}}</td>
            </tr>
        </table>
    </div>

</div>

<h1 class="text-2xl text-green-100 mt-4">Booking History</h1>

<table class="table mt-4">
    <thead>
        <tr>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Room</th>
            <th>Total Payout</th>
            <th><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($guest->bookingGuests as $bg)

            <tr>
                <td>{{$bg->booking->check_in->format('F d, Y')}}</td>
                <td>{{$bg->booking->check_out->format('F d, Y')}}</td>
                <td>{{$bg->booking->room->name}}</td>
                <td class="text-end">{{ number_format( ($bg->booking->room_rent+$bg->booking->addon_total),2)}}</td>
                <td class="text-center">
                    <a href="{{url('/bookings/' . $bg->booking->id)}}" class="text-green-600">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>

        @endforeach
    </tbody>
</table>

@endsection

@section('scripts1')

<script>

$(document).ready(()=>{
    $("#editGuestButton").click(()=>{
        $("#edit-guest-backdrop, #edit-guest-wrapper").removeClass('hidden')
    })

    $("#delete-guest-button").click(()=>{
        $("#delete-guest-backdrop, #delete-guest-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $("#edit-guest-backdrop, #edit-guest-wrapper").addClass('hidden')
        $("#delete-guest-backdrop, #delete-guest-wrapper").addClass('hidden')
    })
})

</script>

@endsection
