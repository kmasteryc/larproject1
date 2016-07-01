@extends('layouts.app')
@section('content')
    <script>
        var json_data_url = '{!! $api_url !!}';
    </script>
    @include('standalones.radio')
@stop