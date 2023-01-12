@extends('base')

@section('content')

<div class="heading-bar">
    <h1 class="title">{{$addon->name}}</h1>
</div>

<div class="flex mt-4 space-x-4">
    <div class="w-1/4 p-4 bg-green-100 rounded-md">
        <h3 class="text-xl text-green-900 mb-4">Addon Details</h3>

        {!! Form::model($addon, ['url'=>'/addons/' . $addon->id, 'method'=>'patch']) !!}

            {!! Form::label("name", "Addon Name", ['class'=>'block']) !!}
            {!! Form::text("name", null, ['class'=>'w-full mb-4']) !!}

            {!! Form::label("description", "Description", ['class'=>'block']) !!}
            {!! Form::textarea("description", null, ['class'=>'mb-4 w-full p-2 rounded border border-green-500','rows'=>4]) !!}

            {!! Form::label("addon_type", "Addon Type", ['class'=>'block']) !!}
            {!! Form::select("addon_type", config('ecotel.addon_types'), null, ['class'=>'mb-4 bg-white p-2 rounded w-full border border-green-500']) !!}

            {!! Form::label("amount", "Amount", ['class'=>'block']) !!}
            {!! Form::number("amount", null, ['class'=>'w-full mb-4','step'=>'.05']) !!}

            <button class="primary" type="submit">
                <i class="fa-solid fa-floppy-disk"></i> Update Addon
            </button>

        {!! Form::close() !!}

        <div class="alert bg-[#d9edb5] mt-6">
            <span class="text-xl text-red-400 block">WARNING!!!</span>
            <div class="mb-4 text-red-900">
                Deleting this addon will also delete all the sales history relating to this addon.
                Deleted transaction history can never be recovered.
                Please proceed with caution.
            </div>
            {!! Form::open(['url'=>'/addons/' . $addon->id, 'method'=>'delete']) !!}
                <button class="danger" type="submit">
                    <i class="fa fa-trash"></i> Delete Addon
                </button>
            {!! Form::close() !!}
        </div>
    </div>

    <div class='w-3/4 p-4 bg-[#2d4135] rounded-md'>
        <h3 class="text-xl text-green-100 mb-8">Sales History</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Guest</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection
