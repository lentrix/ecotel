@extends('base')

@section('content')

@include('rooms._add-room-modal')
@include('rooms._edit-room-modal')
@include('rooms._delete-room-modal')

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
                <button class="secondary edit-room" title="Edit {{$room->name}}"
                            data-id="{{$room->id}}"
                            data-name="{{$room->name}}"
                            data-description="{{$room->description}}"
                            data-type="{{$room->room_type}}"
                            data-rate="{{$room->rate}}">
                    <i class="fa fa-edit"
                            data-id="{{$room->id}}"
                            data-name="{{$room->name}}"
                            data-description="{{$room->description}}"
                            data-type="{{$room->room_type}}"
                            data-rate="{{$room->rate}}"></i>
                </button>
                <button class="danger delete-room" title="Delete room {{$room->name}}"
                        data-id="{{$room->id}}"
                        data-name="{{$room->name}}"
                        data-description="{{$room->description}}">
                    <i class="fa fa-trash"
                            data-id="{{$room->id}}"
                            data-name="{{$room->name}}"
                            data-description="{{$room->description}}"></i>
                </button>
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

    $(".edit-room").click((ev)=>{
        const el = $(ev.target)

        $("#room-id").val(el.data('id'))
        $("#room-name").val(el.data('name'))
        $("#room-description").val(el.data('description'))
        $("#room-type").val(el.data('type')).change()
        $("#room-rate").val(el.data('rate'))

        $("#edit-room-backdrop, #edit-room-wrapper").removeClass('hidden')
    })

    $(".delete-room").click((ev)=>{
        const el = $(ev.target)

        console.log($("#room-name"))

        $("#delete-room-id").val( el.data('id') )
        $("#show-room-name").text(el.data('name'))
        $("#show-room-description").text( el.data('description') )

        $("#delete-room-backdrop, #delete-room-wrapper").removeClass('hidden')
    })

})

</script>

@endsection
