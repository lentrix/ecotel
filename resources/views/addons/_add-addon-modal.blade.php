<div class="absolute top-0 left-0 h-screen w-screen z-10 bg-gray-900 opacity-90 duration-300 hidden modal-backdrop" id="add-addon-backdrop">
</div>

<div class="absolute top-0 left-0 h-screen w-screen z-20 flex items-center justify-center duration-300 hidden modal-wrapper" id="add-addon-wrapper">

    <div class="bg-green-100 w-[500px] p-8 rounded-xl relative" id="add-addon-modal">
        <button class="absolute top-4 right-4 secondary close-modal" data-modal="add-addon">
            <i class="fa fa-close"></i>
        </button>

        <h2 class="text-2xl text-green-900 pb-2 border-b border-green-900">Add New Addon</h2>

        {!! Form::open(['url'=>'/addons', 'method'=>'post']) !!}

        {!! Form::label("name", "Addon Name", ["class"=>'block']) !!}
        {!! Form::text("name", null, ['class'=>'w-full']) !!}

        {!! Form::label("description", "Description", ["class"=>'block']) !!}
        {!! Form::textarea("description", null, ['class'=>'border border-green-500 p-2 w-full mb-4','rows'=>3]) !!}

        {!! Form::label("addon_type", "Addon Type", ['class'=>'block']) !!}
        {!! Form::select("addon_type", config('ecotel.addon_types'), null, ['class'=>'w-full bg-white p-2 rounded mb-4']) !!}

        {!! Form::label("amount", "Amount", ['class'=>'block']) !!}
        {!! Form::number("amount", null, ['class'=>'w-full','step'=>'.01']) !!}

        <button type="submit" class="primary">
            <i class="fa fa-check"></i> Submit
        </button>
        <button class="secondary" type="reset">
            <i class="fa fa-recycle"></i> Reset
        </button>

        {!! Form::close() !!}

    </div>

</div>
