@extends('base')

@section('content')

<div class="flex border border-green-200 mt-[80px]">

    <img src="images/banner.jpg" class="w-1/2">

    <div class="bg-[#1a211d] w-1/2 p-4 text-green-200 flex flex-col items-center">

        <h1 class="text-3xl font-weight-bold mb-8">
            User Login
        </h1>

        {!! Form::open(['url'=>'/login','method'=>'post']) !!}

        {!! Form::label("uname", "User Name", ["class"=>'block']) !!}
        {!! Form::text("uname", null) !!}

        {!! Form::label("password", "Password", ["class"=>'block']) !!}
        {!! Form::password("password") !!}

        <button class="primary block w-[100px]">
            Log In
        </button>

        {!! Form::close() !!}

    </div>

</div>

@endsection
