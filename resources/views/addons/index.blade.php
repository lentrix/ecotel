@extends('base')

@section('content')

@include('addons._add-addon-modal')

<div class="heading-bar">
    <h1 class="title">Manage Addons</h1>

    <button class="primary" data-modal="add-room" id="addAddonButton">
        <i class="fa fa-plus"></i> Create Addon
    </button>
</div>

<table class="table mt-4">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Amount</th>
            <th><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($addons as $addon)
        <tr>
            <td>{{$addon->name}}</td>
            <td>{{$addon->description}}</td>
            <td>{{$addon->addon_type}}</td>
            <td>{{$addon->amount}}</td>
            <td class="text-center">
                <a href="{{url('/addons/' . $addon->id)}}" class="secondary" title="Open {{$addon->name}} addon.">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('scripts1')

<script>

$(document).ready(()=>{

    $("#addAddonButton").click((ev)=>{
        $("#add-addon-backdrop, #add-addon-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $("#add-addon-backdrop, #add-addon-wrapper").addClass('hidden')
    })

})

</script>

@endsection
