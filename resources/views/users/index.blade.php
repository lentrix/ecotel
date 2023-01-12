@extends('base')

@section('content')

@include('users._add-user-modal')

<div class="heading-bar">
    <h1 class="title">
        Manage Users
    </h1>
    <button class="primary" data-modal="add-room" id="addUserButton">
        <i class="fa fa-plus"></i> Create User
    </button>
</div>

<table class="table mt-4">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Full Name</th>
            <th>User Type</th>
            <th><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->uname}}</td>
            <td>{{$user->full_name}}</td>
            <td>{{$user->user_type}}</td>
            <td class="text-center">
                <a href="{{url('/users/' . $user->id)}}" class="secondary" title="Open user">
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

    $("#addUserButton").click((evt)=>{
        $("#add-user-backdrop, #add-user-wrapper").removeClass('hidden')
    })

    $(".close-modal").click(()=>{
        $("#add-user-backdrop, #add-user-wrapper").addClass('hidden')
    })

})

</script>

@endsection
