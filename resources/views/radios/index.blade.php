@extends('layouts.app')
@section('content')
    <script>
        var player_config = {
            mode : 3,
            api_url: '{!! $api_url !!}'
        };
    </script>
    @include('standalones.radio')
@stop