@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">Generate Reports</h1>
</div>

<div class="grid grid-cols-3 grid-gap-10 mt-8">

    <div class="p-4 bg-white rounded-lg shadow-md flex flex-col justify-between items-center text-center">
        {!! Form::open(['url'=>'/reports/daily-summary','method'=>'get','target'=>'_blank']) !!}
        <div class="min-h-[80px]">
            <h3 class="text-lg font-bold">Daily Booking Summary</h3>
            <p class="italic">
                List of bookings for the day (summary)
            </p>
            {!! Form::label("date", "Select date") !!}
            {!! Form::date("date", now(), ['class'=>'w-[140px]']) !!}
        </div>

        <div>

            <button class="secondary" type="submit">
                <i class="fa fa-file-pdf"></i> Generate Report
            </button>
        </div>
        {!! Form::close() !!}
    </div>

</div>

@endsection
