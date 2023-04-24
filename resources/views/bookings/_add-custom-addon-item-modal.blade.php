<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-custom-addon-item-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-custom-addon-item-wrapper">

    <div class="bg-green-100 w-[650px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="add-custom-addon-item-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="add-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add Custom Addon</h2>

        <div class="overflow-auto max-h-[70vh] mt-4">
            {!! Form::open(['url'=>'/bookings/custom-add-on/' . $booking->id,'method'=>'post']) !!}

            {!! Form::label("remarks", "Item Description", ['class'=>'block']) !!}
            {!! Form::text("remarks", null, ['class'=>'w-full mb-3', 'id'=>'others-field']) !!}

            {!! Form::label("qty", "Quantity", ['class'=>'block']) !!}
            {!! Form::number("qty", null, ['class'=>'w-full mb-3', 'id'=>'others-field']) !!}

            {!! Form::label("amount", "Total Amount", ['class'=>'block']) !!}
            {!! Form::number("amount", null, ['class'=>'w-full mb-3', 'id'=>'others-field', 'step'=>'0.10']) !!}

            <div class="mb-3">
                <button class="btn primary" type="submit">
                    Add Item
                </button>
            </div>

            {!! Form::close() !!}
        </div>

    </div>

</div>
