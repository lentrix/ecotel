@extends('base')

@section('content')

@include('guests._add-guest-modal')

<div class="heading-bar">
    <h1 class="title">Manage Guests</h1>

    <button class="primary" data-modal="add-room" id="addGuestButton">
        <i class="fa fa-plus"></i> Add New Guest
    </button>
</div>

<div class="flex mt-4 space-x-4">

    <div class="w-1/4 bg-green-100 p-4 rounded-md">
        <h2 class="text-2xl mb-4">Search Guests</h2>

        {!! Form::open(['url'=>'/guests/search','method'=>'post']) !!}

            {!! Form::label("last_name", "Last Name", ['class'=>'block']) !!}
            {!! Form::text("last_name", null, ['class'=>'w-full mb-4']) !!}

            {!! Form::label("first_name", "First Name", ['class'=>'block']) !!}
            {!! Form::text("first_name", null, ['class'=>'w-full mb-4']) !!}

            <button class="secondary w-full" type="submit">
                <i class="fa fa-search"></i> Search
            </button>

        {!! Form::close() !!}
    </div>

    <div class="bg-[#aabbcc] p-4 rounded-md w-3/4">
        <h2 class="text-2xl mb-4">{{$remarks}}</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th><i class="fa fa-cog"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($guests as $guest)

                <tr>
                    <td>{{$guest->full_name}}</td>
                    <td>{{$guest->address}}</td>
                    <td>{{$guest->country}}</td>
                    <td class="text-center">
                        <a href="{{url('/guests/' . $guest->id)}}" class="secondary" title="View guest details">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts1')

<script>

$(document).ready(()=>{
    $("#addGuestButton").click(()=>{
        $("#add-guest-backdrop, #add-guest-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $("#add-guest-backdrop, #add-guest-wrapper").addClass('hidden')
    })
})

</script>

@endsection
