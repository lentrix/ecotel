<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="edit-current-room-backdrop">
</div>

<div class="absolute top-0 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="edit-current-room-wrapper">

    <div class="bg-green-100 w-[500px] p-8 rounded-xl relative" id="edit-current-room-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="edit-current-room">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Edit Room</h2>

        {!! Form::model($room, ['url'=>'/rooms/', 'method'=>'patch']) !!}

        {!! Form::hidden("id", $room->id,['id'=>'room-id']) !!}

        {!! Form::label("name", "Room Name", ["class"=>'block']) !!}
        {!! Form::text("name", null, ['class'=>'w-full','id'=>'room-name']) !!}

        {!! Form::label("password", "Description", ["class"=>'block']) !!}
        {!! Form::textarea("description", null, ['class'=>'border border-green-500 p-2 w-full mb-4','rows'=>3,'id'=>'room-description']) !!}

        {!! Form::label("room_type", "Room Type", ['class'=>'block']) !!}
        {!! Form::select("room_type", config('ecotel.room_types'), null, ['class'=>'w-full bg-white p-2 rounded mb-4','id'=>'room-type']) !!}

        {!! Form::label("rate", "Room Rate", ['class'=>'block']) !!}
        {!! Form::number("rate", null, ['class'=>'w-full','step'=>'.01','id'=>'room-rate']) !!}

        <button type="submit" class="primary">
            <i class="fa fa-ok"></i> Submit
        </button>

        {!! Form::close() !!}

    </div>

</div>
