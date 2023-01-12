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
        <span class="font-bold text-2xl">Date Selection</span> >
        Room Selection > Addons Selection
    </div>

    {!! Form::open(['url'=>'/bookings/create/page2/' . $guest->id, 'method'=>'post']) !!}
        <div class="text-green-900 p-4 rounded-md bg-green-100 mt-4">

            <h2 class="text-2xl mb-6">Date Selection</h2>

            {!! Form::label("check_in", "Check In", ['class'=>'block']) !!}
            {!! Form::date("check_in", null, ['class'=>'w-full mb-4','required']) !!}

            {!! Form::label("check_out", "Check Out", ['class'=>'block']) !!}
            {!! Form::date("check_out", null, ['class'=>'w-full mb-4','required']) !!}

            <button class="primary" type="submit">
                Next | Room Selection <i class="fa fa-arrow-right"></i>
            </button>

        </div>
    {!! Form::close() !!}
</div>

@endsection
