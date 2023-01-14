@extends('base')

@section('content')


<div class="heading-bar">
    <h1 class="title">Dashboard</h1>
</div>

<div class="grid grid-cols-5 gap-8 mt-4">

    <div class="bg-green-100 p-4 rounded-lg text-center flex flex-col justify-between">
    <h2 class="text-2xl">Guests</h2>
        <div class="text-4xl">{{$numberOfGuests}}</div>
    </div>
    <div class="bg-green-100 p-4 rounded-lg text-center flex flex-col justify-between">
        <h2 class="text-2xl">Current Bookings</h2>
        <div class="text-4xl">{{$currentBookings}}</div>
    </div>
    <div class="bg-green-100 p-4 rounded-lg text-center flex flex-col justify-between">
        <h2 class="text-2xl">Up Coming Bookings</h2>
        <div class="text-4xl">{{$upComingBookings}}</div>
    </div>
    <div class="bg-green-100 p-4 rounded-lg text-center flex flex-col justify-between">
        <h2 class="text-2xl">Rooms</h2>
        <div class="text-4xl">{{$rooms}}</div>
    </div>
    <div class="bg-green-100 p-4 rounded-lg text-center flex flex-col justify-between">
        <h2 class="text-2xl">Add-ons</h2>
        <div class="text-4xl">{{$addOns}}</div>
    </div>

</div>


@endsection
