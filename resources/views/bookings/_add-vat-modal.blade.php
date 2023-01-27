<div class="fixed top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-vat-backdrop">
</div>

<div class="fixed top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-vat-wrapper">

    <div class="bg-green-100 w-[650px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="add-vat-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add VAT</h2>

        <div class="overflow-auto max-h-[70vh]">
            <div class="p-4 bg-green-200 text-green-900 my-8 rounded">
                A 12% VAT amounting to {{ number_format($booking->totalBeforeVat * 0.12, 2) }}
                will be added to this booking.
            </div>
            <div class="flex justify-center">
                {!! Form::open(['url'=>'/bookings/add-vat/' . $booking->id,'method'=>'post']) !!}
                    <button class="primary">
                        <i class="fa-solid fa-percent"></i> Add 12% VAT
                    </button>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

</div>
