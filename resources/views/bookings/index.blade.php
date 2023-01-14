@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">Manage Bookings</h1>
</div>

<div class="mt-4">
    <h2 class="text-2xl text-green-100">Current Bookings</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Guest</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Room</th>
                <th><i class="fa fa-cog"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($currentBookings as $cb)
                <tr>
                    <td class="font-bold">{{$cb->guest->full_name}}</td>
                    <td>{{$cb->check_in->format('F d, Y')}}</td>
                    <td>{{$cb->check_out->format('F d, Y')}}</td>
                    <td>{{$cb->room->name}}</td>
                    <td class="text-center">
                        <a href="{{url('/bookings/' . $cb->id)}}" class="text-green-600">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    <h2 class="text-2xl text-green-100">Up-coming Bookings</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Guest</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Room</th>
                <th><i class="fa fa-cog"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach($upComingBookings as $ub)
                <tr>
                    <td class="font-bold">{{$ub->guest->full_name}}</td>
                    <td>{{$ub->check_in->format('F d, Y')}}</td>
                    <td>{{$ub->check_out->format('F d, Y')}}</td>
                    <td>{{$ub->room->name}}</td>
                    <td class="text-center">
                        <a href="{{url('/bookings/' . $ub->id)}}" class="text-green-600">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
