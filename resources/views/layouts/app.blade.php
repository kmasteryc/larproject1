<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if (isset($mycss))
        @foreach($mycss as $css)
            <link rel="stylesheet" href="{{asset("css/$css")}}">
        @endforeach
    @endif

</head>
<body id="app-layout">

@include('layouts.nav')
@include('layouts.alert')

@yield('content')


        <!-- JavaScripts -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    base_url = "{{asset('/')}}/";
</script>
<script src="{{asset('js/master.js')}}"></script>
@if (isset($myjs))
    @foreach($myjs as $js)
        <script src="{{asset("js/$js")}}"></script>
    @endforeach
@endif
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
