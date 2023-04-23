@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">Activity Log</h1>
</div>

<div class="mt-4">
    {!! Form::open(['url'=>'/logs', 'method'=>'get','class'=>'px-4 flex space-x-4 mb-4']) !!}

        <div class="flex-1">
            {!! Form::label("user_id", "User", ["class"=>'text-white']) !!}
            {!! Form::select("user_id", $users, $request->user_id, ['class'=>'w-full bg-white p-2 rounded mb-4','placeholder'=>'Filter user']) !!}
        </div>
        <div class="flex-1">
            {!! Form::label("date_from", "From", ["class"=>'text-white']) !!}
            {!! Form::date("date_from", $request->from, ['class'=>'w-full bg-white p-2 rounded mb-4']) !!}
        </div>

        <div class="flex-1">
            {!! Form::label("date_to", "To", ["class"=>'text-white']) !!}
            {!! Form::date("date_to", $request->to, ['class'=>'w-full bg-white p-2 rounded mb-4']) !!}
        </div>
        <div class="flex items-center">
            <button class="primary">Filter</button>
        </div>

    {!! Form::close() !!}
    <table class="table">
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>User</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)

            <tr>
                <td>{{ $log->created_at->format('M-d-Y g:i a') }}</td>
                <td>{{ $log->user->uname }}</td>
                <td>{{ $log->description }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
