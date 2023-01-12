<div class="absolute top-0 left-0 min-h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-guest-backdrop">
</div>

<div class="absolute top-0 left-0 min-h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-guest-wrapper">

    <div class="bg-green-100 w-[900px] p-8 rounded-xl relative" id="add-guest-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="add-guest">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add New Guest</h2>

        {!! Form::open(['url'=>'/guests', 'method'=>'post']) !!}

            <div class="flex space-x-4 mt-4">
                <div class='w-1/2'>
                    {!! Form::hidden("added_by", auth()->user()->id) !!}

                    {!! Form::label("last_name", "Last Name", ["class"=>'block']) !!}
                    {!! Form::text("last_name", null, ['class'=>'w-full']) !!}

                    {!! Form::label("first_name", "First Name", ["class"=>'block']) !!}
                    {!! Form::text("first_name", null, ['class'=>'w-full']) !!}

                    {!! Form::label("middle_name", "Middle Name", ["class"=>'block']) !!}
                    {!! Form::text("middle_name", null, ['class'=>'w-full']) !!}

                    {!! Form::label("address", "Address", ["class"=>'block']) !!}
                    {!! Form::textarea("address", null, ['class'=>'w-full border border-green-500 p-2 rounded','rows'=>'4']) !!}

                    {!! Form::label("country", "Country", ["class"=>'block']) !!}
                    {!! Form::select("country", $countries, null, ['class'=>'w-full border border-green-500 p-2 rounded bg-white','placeholder'=>'Select a country']) !!}
                </div>

                <div class="w-1/2">
                    {!! Form::label("phone", "Phone", ["class"=>'block']) !!}
                    {!! Form::text("phone", null, ['class'=>'w-full']) !!}

                    {!! Form::label("email", "Email", ["class"=>'block']) !!}
                    {!! Form::email("email", null, ['class'=>'w-full']) !!}

                    {!! Form::label("company", "Company Name", ["class"=>'block']) !!}
                    {!! Form::text("company", null, ['class'=>'w-full']) !!}

                    {!! Form::label("company_address", "Company Address", ["class"=>'block']) !!}
                    {!! Form::textarea("company_address", null, ['class'=>'w-full border border-green-500 p-2 rounded','rows'=>'4']) !!}

                    {!! Form::label("company_tin", "Company TIN", ["class"=>'block']) !!}
                    {!! Form::text("company_tin", null, ['class'=>'w-full']) !!}
                </div>
            </div>





            <button type="submit" class="primary mt-4">
                <i class="fa fa-check"></i> Submit
            </button>
            <button class="secondary" type="reset">
                <i class="fa fa-recycle"></i> Reset
            </button>

        {!! Form::close() !!}

    </div>

</div>
