<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="checkout-backdrop">
</div>

<div class="absolute top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="checkout-wrapper">

    <div class="bg-green-100 w-[650px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="checkout-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Checkout</h2>

        <div class="overflow-auto max-h-[70vh]">
            {!! Form::open(['url'=>'/bookings/checkout/' . $booking->id, 'method'=>'post']) !!}

                {!! Form::label("final_payment") !!}
                {!! Form::number("final_payment", null, ['class'=>"w-full mb-4",'required','step'=>'.01']) !!}

                {!! Form::label("final_pmt_mode") !!}
                {!! Form::select("final_pmt_mode",config('ecotel.payment_modes'),null,
                        ['class'=>"w-full mb-4 bg-white p-2 rounded border border-green-500",'required']) !!}

                <div class="mt-3">
                    <button class="primary">
                        <i class="fa fa-check"></i> Checkout
                    </button>
                </div>
            {!! Form::close() !!}
        </div>

    </div>

</div>
