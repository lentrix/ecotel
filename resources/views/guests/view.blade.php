@extends('base')

@section('content')

@include('guests._edit-guest-modal')

<div class="heading-bar">
    <h1 class="title">Guest: {{$guest->full_name}}</h1>
    <div class="flex space-x-4">
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
                    {{$guest->middle_name}}
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
        </tr>
    </thead>
</table>

@endsection

@section('scripts1')

<script>

$(document).ready(()=>{
    $("#editGuestButton").click(()=>{
        $("#edit-guest-backdrop, #edit-guest-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $("#edit-guest-backdrop, #edit-guest-wrapper").addClass('hidden')
    })
})

</script>

@endsection
