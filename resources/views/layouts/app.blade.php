<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header', ['title' => @$title ?? config('app.name', 'Homecare - Tukangku')])

<body>
    @yield('content')
  
    <script src="{{url('/')}}/assets/lib/jquery/jquery.js"></script>
    <script src="{{url('/')}}/assets/lib/popper.js/popper.js"></script>
    <script src="{{url('/')}}/assets/lib/bootstrap/bootstrap.js"></script>
</body>
</html>
