@extends('base')

@section('content')

@include('rooms._add-room-modal')

<div class="heading-bar">
    <h1 class="title">Manage Rooms</h1>
    <button class="primary" data-modal="add-room" id="addRoomButton">
        <i class="fa fa-plus"></i> Add Room
    </button>
</div>

<div class="grid grid-cols-3 grid-gap-10 mt-8">

    @foreach($rooms as $room)

    <div class="bg-green-100 p-4 w-[350px] rounded-lg mb-10 flex flex-col">
        <h2 class="text-2xl">{{$room->name}}</h2>
        <p class="flex-1">{{$room->description}}</p>
        <div class="mt-4 text-3xl text-green-700 border-b-2 border-green-700 pb-2">
            <i class="fa-solid fa-peso-sign"></i> {{ number_format($room->rate,2)}}
        </div>
        <div class="flex justify-between mt-2">
            <div class="flex justify-start space-x-2">
                <a href="{{url('/rooms/' . $room->id)}}" class="secondary" title="View {{$room->name}}">
                    <i class="fa fa-eye"></i>
                </a>

            </div>

            <a href="{{url('/rooms/' . $room->id)}}" class="secondary" title="View Booking">
                <i class="fa-solid fa-person"></i> Occupied
            </a>
        </div>
    </div>

    @endforeach

</div>

@endsection


@section('scripts1')

<script>

$(document).ready(()=>{

    $("#addRoomButton").click((ev)=>{
        $("#add-room-backdrop, #add-room-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $(".modal-backdrop, .modal-wrapper").addClass('hidden')
    })

})

</script>

@endsection
