<div class="fixed top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="remove-vat-backdrop">
</div>

<div class="fixed top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="remove-vat-wrapper">

    <div class="bg-green-100 w-[650px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="remove-vat-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Remove VAT</h2>

        <div class="overflow-auto max-h-[70vh]">
            <div class="p-4 bg-green-200 text-green-900 my-8 rounded">
                You are about to remove the 12% VAT from this Booking
            </div>
            <div class="flex justify-center">
                {!! Form::open(['url'=>'/bookings/remove-vat/' . $booking->id,'method'=>'post']) !!}
                    <button class="primary">
                        <i class="fa-solid fa-trash"></i> Remove 12% VAT
                    </button>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

</div>
