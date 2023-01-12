@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">{{$user->full_name}}</h1>
</div>

<div class="flex space-x-4 mt-4">

    <div class="w-1/4 p-4 bg-green-100 rounded-md">
        <h2 class="text-2xl">User Details</h2>

        {!! Form::model($user, ['url'=>'/users/' . $user->id, 'method'=>'patch']) !!}

            {!! Form::label("uname", "User Name", ["class"=>'block']) !!}
            {!! Form::text("uname", null, ['class'=>'w-full']) !!}

            {!! Form::label("full_name", "Full Name", ["class"=>'block']) !!}
            {!! Form::text("full_name", null, ['class'=>'w-full']) !!}

            {!! Form::label("user_type", "User Type", ['class'=>'block']) !!}
            {!! Form::select("user_type", config('ecotel.user_types'), null, ['class'=>'w-full bg-white p-2 rounded mb-4']) !!}

            <button class="primary" type="submit">
                <i class="fa-solid fa-floppy-disk"></i> Update User
            </button>

        {!! Form::close() !!}

        <div class="mt-4 pt-4 border-t border-green-500">
            <h2 class="text-xl mb-4">Change Password</h2>

            {!! Form::open(['url'=>'/users/change-password/' . $user->id,'method'=>'post']) !!}

                {!! Form::label("password", "New Password", ['class'=>'block']) !!}
                {!! Form::password("password", ['class'=>'w-full mb-4']) !!}

                {!! Form::label("password_confirmation", "Confirm New Password", ['class'=>'block']) !!}
                {!! Form::password("password_confirmation", ['class'=>'w-full mb-4']) !!}

                <button class="primary" type="submit">
                    <i class="fa fa-lock"></i> Change Password
                </button>

            {!! Form::close() !!}
        </div>

        <div class="mt-4 pt-4 border-t border-green-500">

            <span class="text-xl text-red-400 block">WARNING!!!</span>
            <div class="mb-4 text-red-900">
                Deleting this User will also delete all the bookings performed by this user.
                Deleted transaction history can never be recovered.
                Please proceed with caution.
            </div>

            {!! Form::open(['url'=>'/users/' . $user->id,'method'=>'delete']) !!}

                <button class="danger" type="submit">
                    <i class="fa fa-trash"></i> Delete User
                </button>

            {!! Form::close() !!}
        </div>

    </div>
    <div class="w-3/4 bg-[#283427] p-4 rounded-md text-green-100">
        <h2 class="text-2xl">User Access History</h2>
    </div>

</div>

@endsection
