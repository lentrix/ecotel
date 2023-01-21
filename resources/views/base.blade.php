<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/fontawesome/css/all.css">
    <script src="/js/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <title>Ecotel Application</title>
    @vite('resources/css/app.css')
</head>
<body style="background-color: #060b12; background-image: url('/images/background.jpg'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed">


    <div class="w-[1200px] min-h-screen mx-auto pb-[50px]">

        <header class=" text-green-200 font-weight-semibold mb-8 mt-4 flex items-center justify-between">
            <div class="flex items-center">
                <img src="/images/logo.jpg" class="h-[80px]" alt="">
                <h1 class="text-3xl ml-4">BOHOL ECOTEL</h1>
            </div>

            @if(!auth()->guest())
                <nav class="text-lg space-x">
                    <a href="{{url('/home')}}" class="main-nav">Home</a>
                    <a href="{{url('/bookings')}}" class="main-nav">Bookings</a>
                    <a href="{{url('guests')}}" class="main-nav">Guests</a>
                    <a href="{{url('reports')}}" class="main-nav">Reports</a>
                    @if(auth()->user()->user_type=='admin')
                        <a href="{{url('/rooms')}}" class="main-nav">Rooms</a>
                        <a href="{{url('/addons')}}" class="main-nav">Addons</a>
                        <a href="{{url('/users')}}" class="main-nav">Users</a>
                    @endif
                    {!! Form::open(['url'=>'/logout','method'=>'post','class'=>'inline']) !!}
                        <button type="submit" class="main-nav">Log Out</button>
                    {!! Form::close() !!}
                    <span class="bg-[#222b27] text-lg text-green-500 p-2 rounded-md"><i class="fa fa-user"></i> {{auth()->user()->uname}}</span>
                </nav>
            @endif
        </header>

        @include('flash-messages')

        @yield('content')


    </div>

    <footer class="text-center text-[#6f906c] mt-[-50px]">
        Copyright &copy; 2023 Bohol Ecotel, Inc. All rights reserved
    </footer>

    @yield('scripts1')
</body>
</html>
