@extends('base')

@section('content')

{!! Form::open(['url'=>'/bookings/create/page3/' . $guest->id, 'method'=>'post','id'=>'form']) !!}
    <input type="hidden" name="check_in" id="check_in" value="{{$check_in}}">
    <input type="hidden" name="check_out" id="check_out" value="{{$check_out}}">
    <input type="hidden" name="source" id="source" value="{{$source}}">
    <input type="hidden" name="purpose" id="purpose" value="{{$purpose}}">
    <input type="hidden" name="with_breakfast" id="with_breakfast" value="{{$with_breakfast}}">

    <input type="hidden" name="room_id" id="room_id">
{!! Form::close() !!}

<div class="heading-bar">
    <h1 class="title">Create Booking</h1>
    <div class="bg-pink-300 py-1 px-4 rounded-md">
        <h3 class="text-2xl">{{$guest->full_name}}</h3>
    </div>
</div>

<div class="w-7/12 mx-auto py-4 text-xl text-green-300">
    <div>
        Date &amp; Other Selections >
        <span class="font-bold text-2xl">Room Selection</span> > Finalize Booking
    </div>

    <div class="text-green-300 p-4 rounded-md bg-green-900 mt-4">
        <h2 class="text-2xl mb-6">Date &amp; Source Selection</h2>

        <div><strong>Check In:</strong> {{$check_in->format('F d, Y')}}</div>
        <div><strong>Check Out:</strong> {{$check_out->format('F d, Y')}}</div>
        <div><strong>Booking Source:</strong> {{$source}}</div>
        <div><strong>Purpose of underdating:</strong> {{$purpose}}</div>
        <div><strong>With breakfast:</strong> {{$with_breakfast}}</div>
    </div>

    <div class="text-green-900 p-4 rounded-md bg-green-100 mt-4">

        <h2 class="text-2xl mb-6">Room Selection</h2>

        @foreach($rooms as $room)

            <div class="bg-white rounded-md mb-2 border border-gray-300 flex">
                <div class='flex-1 p-2'>
                    <div class="text-xl font-bold">{{$room->name}}</div>
                    <div class="text-sm italic ">{{$room->description}}</div>
                    <div class="text-xl text-green-700 font-bold"><i class="fa-solid fa-peso-sign"></i> {{ $room->rate }}</div>
                </div>
                <button class="bg-green-700 text-white px-3 hover:bg-green-600 duration-300 select-button" data-room_id="{{$room->id}}">
                    <i class="fa-solid fa-chevron-right" data-room_id="{{$room->id}}"></i>
                </button>
            </div>

        @endforeach

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
