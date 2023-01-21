@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">Create Booking</h1>
    <div class="bg-pink-300 py-1 px-4 rounded-md">
        <h3 class="text-2xl">{{$guest->full_name}}</h3>
    </div>
</div>

<div class="w-8/12 mx-auto py-4 text-xl text-green-300">
    <div>
        <span class="font-bold text-2xl">Date &amp; Other Selections</span> >
        Room Selection > Finalize Booking
    </div>

    {!! Form::open(['url'=>'/bookings/create/page2/' . $guest->id, 'method'=>'post']) !!}
        <div class="text-green-900 p-4 rounded-md bg-green-100 mt-4">

            <h2 class="text-2xl mb-6">Date &amp; Other Selections</h2>

            {!! Form::label("check_in", "Check In", ['class'=>'block']) !!}
            {!! Form::date("check_in", null, ['class'=>'w-full mb-4','required']) !!}

            {!! Form::label("check_out", "Check Out", ['class'=>'block']) !!}
            {!! Form::date("check_out", null, ['class'=>'w-full mb-4','required']) !!}

            {!! Form::label("source", "Booking Source", ['class'=>'block']) !!}
            {!! Form::select("source", config('ecotel.booking_source'), null,
                    ['class'=>'w-full mb-4 bg-white p-2 rounded','required']) !!}

            {!! Form::label("purpose", "Purpose of undertaking") !!}
            {!! Form::select("purpose", [
                'Leisure/Vacation' => 'Leisure/Vacation',
                'Business' => 'Business',
                'Events' => 'Events',
                'Others' => 'Others',
            ], null, ['id'=>'purpose-selection','class'=>'w-full bg-white p-2 rounded border border-green-500 mb-3','required']) !!}
            {!! Form::text("other_purpose", null, ['class'=>'hidden w-full', 'id'=>'others-field','placeholder'=>'Please specify']) !!}

            <div class='mb-3'>
                {!! Form::checkbox("with_breakfast", null, false,['id'=>'with_breakfast']) !!}
                {!! Form::label("with_breakfast", "With breakfast") !!}
            </div>

            <button class="primary" type="submit">
                Next | Room Selection <i class="fa fa-arrow-right"></i>
            </button>

        </div>
    {!! Form::close() !!}
</div>

@endsection

@section('scripts1')

<script>

$(document).ready(()=>{
    $("#purpose-selection").change((ev)=>{
        if($(ev.target).find(":selected").val() == "Others") {
            $("#others-field").removeClass('hidden')
            $("#others-field").focus()
        }else {
            $("#others-field").addClass('hidden')
        }
    })
})

</script>

@endsection
