<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="cancel-booking-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="cancel-booking-wrapper">

    <div class="bg-green-100 w-[650px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="cancel-booking-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Cancel Booking</h2>

        <div class="overflow-auto max-h-[70vh]">
            <div class="p-4 bg-red-200 text-red-600 my-8 rounded">
                You are about to cancel this booking. Please confirm your intention.
            </div>
            <div class="flex justify-center">
                {!! Form::open(['url'=>'/bookings/cancel/' . $booking->id,'method'=>'post']) !!}
                    <button class="danger">
                        <i class="fa fa-ban"></i> Cancel Booking
                    </button>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

</div>
