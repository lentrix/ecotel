@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">Create Booking</h1>
    <div class="bg-pink-300 py-1 px-4 rounded-md">
        <h3 class="text-2xl">{{$guest->full_name}}</h3>
    </div>
</div>

<div class="w-1/2 mx-auto py-4 text-xl text-green-300">
    <div>
        Date &amp; Other Selections >
        Room Selection > <span class="font-bold text-2xl">Finalize Booking</span>
    </div>

    <div class="text-green-300 p-4 rounded-md bg-green-900 mt-4">
        <h2 class="text-2xl mb-6">Date Selection</h2>

        <div><strong>Check In:</strong> {{$check_in->format('F d, Y')}}</div>
        <div><strong>Check Out:</strong> {{$check_out->format('F d, Y')}}</div>
        <div><strong>Booking Source:</strong> {{$source}}</div>
        @if($online_booking_id)
            <div><strong>Booking ID:</strong> {{$online_booking_id}}</div>
        @endif
        <div><strong>Purpose of undertaking:</strong> {{$purpose}}</div>
        <div><strong>With breakfast:</strong> {{$with_breakfast}}</div>

    </div>

    <div class="text-green-300 p-4 rounded-md bg-green-900 mt-4">
        <h2 class="text-2xl mb-6">Room Selection</h2>

        <div class="text-xl font-bold">{{$room->name}}</div>
        <div class="italic ">{{$room->description}}</div>
        <div class="text-xl text-pink-200 font-bold"><i class="fa-solid fa-peso-sign"></i> {{ $room->rate }}</div>
    </div>

    <div class="text-green-900 p-4 rounded-md bg-green-300 mt-4">
        {!! Form::open(['url'=>'/bookings/create/finalize', 'method'=>'post','id'=>'form']) !!}
            <input type="hidden" name="check_in" id="check_in" value="{{$check_in}}">
            <input type="hidden" name="check_out" id="check_out" value="{{$check_out}}">
            <input type="hidden" name="source" id="source" value="{{$source}}">
            <input type="hidden" name="room_id" id="room_id" value="{{$room->id}}">
            <input type="hidden" name="guest_id" id="guest_id" value="{{$guest->id}}">
            <input type="hidden" name="room_rate" id="room_rate" value="{{$room->rate}}">
            <input type="hidden" name="purpose" id="purpose" value="{{$purpose}}">
            <input type="hidden" name="with_breakfast" id="with_breakfast" value="{{$with_breakfast=="Yes" ? 1 : 0}}">
            <input type="hidden" name="added_by" id="added_by" value="{{auth()->user()->id}}">

            <button class="primary" type="submit">
                <i class="fa fa-check"></i> Finalize Booking
            </button>
        {!! Form::close() !!}
    </div>
</div>


@endsection

@section('scripts1')

<script>

$(document).ready(()=>{
    $(".select-button").click((ev)=>{
        const el = $(ev.target)
        const roomId = el.data('room_id')

        $("#room_id").val(roomId)
        $("#form").trigger('submit')
    })
})

</script>

@endsection
