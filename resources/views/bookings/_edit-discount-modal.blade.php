<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="edit-discount-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="edit-discount-wrapper">

    <div class="bg-green-100 w-[400px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="edit-discount-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Edit Discount</h2>

        <div class="overflow-auto max-h-[70vh]">

            {!! Form::model($booking, ['url'=>'/bookings/' . $booking->id,'method'=>'patch']) !!}

                <div class="mb-3">
                    {!! Form::label("discount_remarks", "Remarks") !!}
                    {!! Form::text("discount_remarks", null, ['class'=>'w-full']) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label("discount_amount", "Amount") !!}
                    {!! Form::number("discount_amount", null, ['class'=>'w-full','step'=>'0.01']) !!}
                </div>

                <button class="primary" type="submit">
                    <i class="fa fa-save"></i> Save Changes
                </button>

            {!! Form::close() !!}

        </div>

    </div>

</div>
