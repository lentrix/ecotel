@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">
        Edit Booking
    </h1>
</div>


<div class="w-7/12 mx-auto py-4 text-xl text-green-300">
    <div>
        <h3 class="text-2xl">Guest: {{ $booking->guest->full_name }}</h3>
    </div>

    <div class="text-green-900 p-4 rounded-md bg-green-100 mt-4">
        {!! Form::model($booking, ['url'=>'/bookings/'. $booking->id,'method'=>'put']) !!}

            {!! Form::label("room_id", "Room", ['class'=>'block']) !!}
            {!! Form::select("room_id", $rooms,$booking->room_id, ['class'=>'w-full mb-4 bg-white p-2 rounded border-green-500 border','required']) !!}

            {!! Form::label("check_in", "Check In", ['class'=>'block']) !!}
            {!! Form::date("check_in", $booking->check_in, ['class'=>'w-full mb-4','required']) !!}

            {!! Form::label("check_out", "Check Out", ['class'=>'block']) !!}
            {!! Form::date("check_out", $booking->check_out, ['class'=>'w-full mb-4','required']) !!}

            {!! Form::label("source", "Booking Source", ['class'=>'block']) !!}
            {!! Form::select("source", config('ecotel.booking_source'), $booking->source,
                    ['class'=>'w-full mb-4 bg-white p-2 rounded','required']) !!}

            <div id="booking_id_block" @if($booking->source!="Via Agoda" && $booking->source!="Via Booking.com") class="hidden" @endif>
                {!! Form::label("online_booking_id", "Booking ID") !!}
                {!! Form::text("online_booking_id", null, ['class'=>'w-full mb-4']) !!}
            </div>

            {!! Form::label("purpose", "Purpose of undertaking") !!}
            {!! Form::select("purpose", [
                'Leisure/Vacation' => 'Leisure/Vacation',
                'Business' => 'Business',
                'Events' => 'Events',
                'Others' => 'Others',
            ], null, ['id'=>'purpose-selection','class'=>'w-full bg-white p-2 rounded border border-green-500 mb-3','required']) !!}
            {!! Form::text("other_purpose", $booking->other_purpose, ['class'=>'hidden w-full', 'id'=>'others-field','placeholder'=>'Please specify']) !!}

            <div class='mb-3'>
                {!! Form::checkbox("with_breakfast", 1, $booking->with_breakfast,['id'=>'with_breakfast']) !!}
                {!! Form::label("with_breakfast", "With breakfast") !!}
            </div>

            <div class="mb-3 flex justify-between">
                <button class="btn primary" type="submit">
                    <i class="fa fa-save"></i> Save Changes
                </button>

                <a href="{{url('/bookings/' . $booking->id)}}" class="btn danger">
                    <i class="fa fa-ban"></i> Cancel
                </a>
            </div>

        {!! Form::close() !!}
    </div>
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

    $("#source").change((ev)=>{
        let val = $(ev.target).find(":selected").val();
        if(val == "Via Agoda" || val=="Via Booking.com") {
            $("#booking_id_block").removeClass('hidden')
            $("#online_booking_id").focus()
        }else {
            $("#booking_id_block").addClass('hidden')
            $("#online_booking_id").attr('value',null)
        }
    })
})

</script>

@endsection
