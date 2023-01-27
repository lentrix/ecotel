<div class="fixed top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-surcharge-backdrop">
</div>

<div class="fixed top-0 px-10 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-surcharge-wrapper">

    <div class="bg-green-100 w-[500px] max-h-[90%] p-8 mx-10 rounded-xl relative" id="add-surcharge-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="delete-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add Surcharge</h2>

        <div class="overflow-auto max-h-[70vh]">
            <div class="p-4 bg-green-200 text-green-900 my-8 rounded">
                For Credit Card/Debit Card payments, certain surcharges will be applied.
                Please enter the following data:
            </div>
            {!! Form::open(['url'=>'/bookings/add-surcharge/' . $booking->id, 'method'=>'post']) !!}

                <div>
                    {!! Form::label("percent", "Surcharge Percentage:") !!}
                    {!! Form::text("percent", null, ['class'=>'w-[100px] ms-2','required']) !!}
                    %
                </div>

                <div>
                    <div>Charged on...</div>
                    <div class="flex space-x-4">
                        <div>
                            <input type="radio" name="portion" id="down-payment" value="down payment" required>
                            <label for="down-payment">Down Payment</label>
                        </div>
                        <div>
                            <input type="radio" name="portion" id="balance" value="balance">
                            <label for="balance">Balance</label>
                        </div>
                        <div>
                            <input type="radio" name="portion" id="total" value="total">
                            <label for="total">Total</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="primary mt-4">
                    <i class="fa fa-plus"></i> Add Surcharge
                </button>

            {!! Form::close() !!}
        </div>

    </div>

</div>
