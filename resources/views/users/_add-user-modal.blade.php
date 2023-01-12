<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-user-backdrop">
</div>

<div class="absolute top-0 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-user-wrapper">

    <div class="bg-green-100 w-[500px] p-8 rounded-xl relative" id="add-user-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="add-user">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add New User</h2>

        {!! Form::open(['url'=>'/users', 'method'=>'post']) !!}

        {!! Form::label("uname", "User Name", ["class"=>'block']) !!}
        {!! Form::text("uname", null, ['class'=>'w-full']) !!}

        {!! Form::label("full_name", "Full Name", ["class"=>'block']) !!}
        {!! Form::text("full_name", null, ['class'=>'w-full']) !!}

        {!! Form::label("user_type", "User Type", ['class'=>'block']) !!}
        {!! Form::select("user_type", config('ecotel.user_types'), null, ['class'=>'w-full bg-white p-2 rounded mb-4']) !!}

        {!! Form::label("password", "Password", ['class'=>'block']) !!}
        {!! Form::password("password",['class'=>'w-full']) !!}

        <button type="submit" class="primary">
            <i class="fa fa-check"></i> Submit
        </button>
        <button class="secondary" type="reset">
            <i class="fa fa-recycle"></i> Reset
        </button>

        {!! Form::close() !!}

    </div>

</div>
