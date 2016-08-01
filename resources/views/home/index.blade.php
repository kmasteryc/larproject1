@extends('layouts.app')

@section('content')
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                @include('home.partials.slider')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('home.partials.hot_album')
            </div>
        </div>

    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                @include('home.partials.chart')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('home.partials.topic')
            </div>
        </div>
    </div>
@endsection
