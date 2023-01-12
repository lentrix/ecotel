<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="delete-room-backdrop">
</div>

<div class="absolute top-0 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="delete-room-wrapper">

    <div class="bg-green-100 w-[500px] p-8 rounded-xl relative" id="delete-room-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-room">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Delete Room</h2>

        <div class="py-4">
            <div id="show-room-name" class="font-weight-bold text-lg"></div>
            <div id="show-room-description"></div>
        </div>

        <div class="alert alert-danger mt-3">
            Deleting this room will also delete all the Bookings made on this room. <br>
            Do you want to continue?
        </div>

        <div class="flex justify-between">
            {!! Form::open(['url'=>'/rooms/', 'method'=>'delete']) !!}

                {!! Form::hidden("id", null,['id'=>'delete-room-id']) !!}

                <button type="submit" class="danger">
                    <i class="fa fa-trash"></i> Delete
                </button>

            {!! Form::close() !!}

            <button type="submit" class="secondary close-modal ml-auto">
                <i class="fa fa-ban"></i> Cancel
            </button>

        </div>

    </div>

</div>
