<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="confirm-booking-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="confirm-booking-wrapper">

    <div class="bg-green-100 w-[400px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="confirm-booking-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Confirm Booking</h2>

        <div class="overflow-auto max-h-[70vh] mt-4">

            {!! Form::open(['url'=>'/bookings/confirm/' . $booking->id,'method'=>'post']) !!}
                <input type="hidden" name="booking_id" value="{{$booking->id}}">

                {!! Form::label("down_payment") !!}
                {!! Form::number("down_payment", null, ['class'=>"w-full mb-4",'required']) !!}

                {!! Form::label("payment_mode") !!}
                {!! Form::select("payment_mode",config('ecotel.payment_modes'),null,
                        ['class'=>"w-full mb-4 bg-white p-2 rounded border border-green-500",'required']) !!}

                <button class="primary">
                    <i class="fa fa-check"></i> Confirm Booking
                </button>
            {!! Form::close() !!}

        </div>

    </div>

</div>
