<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="fb:admins" content="{100003845746305}"/>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="public">

    <title>{!! $title or 'Laravel MP3' !!}</title>

    <!-- Fonts -->
    {{--<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/easy-autocomplete.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/easy-autocomplete.themes.min.css')}}">--}}
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    @if (isset($mycss))
        @foreach($mycss as $css)
            <link rel="stylesheet" href="{{asset("css/$css")}}">
        @endforeach
    @endif

</head>
<body id="app-layout">
<div id="fb-root"></div>

@include('layouts.nav')
@include('layouts.alert')

<div class="container">
    <div class="row">
        @if (isset($cp))
            @if (auth()->user()->level == 2)
                @include('layouts.admin_panel')
            @else
                @include('layouts.user_panel')
            @endif
        @endif
        @yield('content')
    </div>
</div>


<!-- JavaScripts -->
<script>
    base_url = "{{asset('/')}}";
</script>

{{--<script src="{{asset('js/jquery.min.js')}}"></script>--}}
{{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset('js/jquery.easy-autocomplete.min.js')}}"></script>--}}
{{--<script src="{{asset('js/master.js')}}"></script>--}}
{{--<script src="{{asset('js/player.js')}}"></script>--}}

<script src="{{asset('js/all.js')}}"></script>

@if (isset($myjs))
    @foreach($myjs as $js)
        <script src="{{asset("js/$js")}}"></script>
    @endforeach
@endif

</body>
</html>
