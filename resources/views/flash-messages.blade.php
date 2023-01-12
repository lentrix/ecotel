@if (session('Error'))
<div class="alert alert-danger">
    <div class="container">
        {!! session('Error') !!}
    </div>
</div>
@endif

@if (session('Info'))
<div class="alert alert-info">
    <div class="container">
        {!! session('Info') !!}
    </div>
</div>
@endif

@if(session('errors'))
<div class="alert alert-danger">
    <div class="container">
        Please fix the following errors
        <ul>
            @foreach(session('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
