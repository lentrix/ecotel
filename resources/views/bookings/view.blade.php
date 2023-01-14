@extends('base')

@section('content')

@include('bookings._add-addon-item-modal',['addons'=>$addons])

<div class="heading-bar">
    <h1 class="title">View Booking</h1>
</div>

<div class="flex space-x-4 mt-4">

    <div class='w-5/12 p-4 rounded-md bg-green-100'>
        <h2 class="text-2xl pb-5">Booking Details</h2>

        <table class="table">
            <tr>
                <th class="bg-green-900 text-green-200">Guest Name</th>
                <td class="bg-white font-bold text-lg">{{$booking->guest->full_name}}</td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Check In</th>
                <td class="bg-white">{{$booking->check_in->format('F d, Y')}}</td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Check Out</th>
                <td class="bg-white">{{$booking->check_out->format('F d, Y')}}</td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Room</th>
                <td class="bg-white">
                    <div class='font-bold'>{{$booking->room->name}}</div>
                    <div class="italic">{{$booking->room->description}}</div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Room Fee</th>
                <td class="bg-white">
                    <div class="font-bold">
                        <i class="fa-solid fa-peso-sign"></i> {{ number_format($booking->room_rent,2) }}
                    </div>
                    <div class='italic'>
                        {{$booking->nights}} nights @ {{$booking->room->rate}}
                    </div>
                </td>
            </tr>
            <tr>
                <th class="bg-green-900 text-green-200">Add-ons</th>
                <td class="bg-white">
                    <div class='font-bold'>
                        <i class="fa-solid fa-peso-sign"></i>
                        {{number_format($booking->addonTotal,2)}}
                    </div>
                </td>
            </tr>
            <tr class="text-2xl">
                <th class="bg-green-900 text-green-200">TOTAL</th>
                <td class="bg-white">
                    <div class='font-bold'>
                        <i class="fa-solid fa-peso-sign"></i>
                        {{number_format( ($booking->addonTotal + $booking->room_rent),2)}}
                    </div>
                </td>
            </tr>

        </table>
    </div>

    <div class="w-7/12 rounded-md bg-green-50 p-4">
        <div class='flex justify-between pb-3'>
            <h2 class="text-2xl mb-3">Addons</h2>
            <button class="secondary" type="button" id="addAddonItemButton">
                <i class="fa fa-plus"></i> Add Item
            </button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Addon Item</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th><i class="fa fa-cog"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($booking->bookingAddons as $bka)
                    <tr>
                        <td>{{$bka->addon->name}}</td>
                        <td class="text-center">{{$bka->qty}}&#64;{{$bka->addon->amount}}</td>
                        <td class="text-end">{{number_format($bka->amount,2)}}</td>
                        <td class="text-center">
                            {!! Form::open(['url'=>'/bookings/add-on/' . $booking->id,'method'=>'delete']) !!}
                                <input type="hidden" name="addon_id" value="{{$bka->addon_id}}">
                                <button type="submit" class="text-red-500" title="Remove this addon item">
                                    <i class="fa fa-trash"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                    <tr class="font-bold">
                        <td colspan="2">
                            TOTAL
                        </td>
                        <td class="text-end">
                            <i class="fa-solid fa-peso-sign"></i> {{number_format($booking->addonTotal,2)}}
                        </td>
                        <td></td>
                    </tr>
            </tbody>
        </table>

    </div>

</div>

@endsection


@section('scripts1')

<script>

$(document).ready(()=>{
    $("#addAddonItemButton").click(()=>{
        $("#add-addon-item-backdrop, #add-addon-item-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $("#add-addon-item-backdrop, #add-addon-item-wrapper").addClass('hidden')
    })
})

</script>

@endsection
