@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">Generate Reports</h1>
</div>

<div class="grid grid-cols-3 gap-8 mt-8">

    <div class="p-4 bg-white rounded-lg shadow-md flex flex-col justify-between items-center text-center">
        {!! Form::open(['url'=>'/reports/daily-summary','method'=>'get','target'=>'_blank']) !!}
        <div class="min-h-[230px] flex-1">
            <h3 class="text-lg font-bold">Daily Booking Summary</h3>
            <p class="italic mb-4">
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

    <div class="p-4 bg-white rounded-lg shadow-md flex flex-col justify-between items-center text-center">
        {!! Form::open(['url'=>'/reports/daily-income', 'method'=>'get','target'=>'_blank']) !!}

        <div class="min-h-[230px] flex-1">
            <h3 class="text-lg font-bold">Daily Income Report</h3>
            <p class="italic mb-4">
                Listing of daily income per relevant item.
            </p>
            <div>
                {!! Form::label("date", "Select date") !!}
                {!! Form::date("date", now(), ['class'=>'w-[140px]']) !!}
            </div>
            <div class="mb-8">
                {!! Form::label("addon_type", "Select Type") !!}
                {!! Form::select("addon_type", $addonTypes,null, ['class'=>'w-[140px] p-2 rounded border border-green-500']) !!}
            </div>
        </div>

        <div>

            <button class="secondary" type="submit">
                <i class="fa fa-file-pdf"></i> Generate Report
            </button>
        </div>

        {!! Form::close() !!}
    </div>

    <div class="p-4 bg-white rounded-lg shadow-md flex flex-col justify-between items-center text-center">
        {!! Form::open(['url'=>'/reports/periodic-report','method'=>'get','target'=>'_blank']) !!}
        <div class="min-h-[230px] flex-1">
            <h3 class="text-lg font-bold">Periodic Income Report</h3>
            <p class="italic mb-4">
                Summative periodic report on income accross all items
            </p>

            <div>
                {!! Form::label("date_from", "Date from") !!}
                {!! Form::date("date_from", now(), ['class'=>'w-[140px]']) !!}
            </div>

            <div>
                {!! Form::label("date_to", "Date to") !!}
                {!! Form::date("date_to", now(), ['class'=>'w-[140px]']) !!}
            </div>

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
