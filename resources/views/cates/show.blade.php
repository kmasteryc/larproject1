@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <h3>Album {!! $cate->cate_title !!}</h3>
            <div class="row thumbnail-row">
                <script> var cate = '{!! $cate->id !!}';</script>
                <ul class="list-group" id="hot-album"></ul>
            </div>
            <div class="row">
                <div style="text-align: center" id="hot-album-pageinate"></div>
            </div>
            <h3>Bài hát {!! $cate->cate_title !!}</h3>
            <div class="row">

                <ul class="list-group" id="hot-song"></ul>
            </div>
            <div class="row">
                <div style="text-align: center" id="hot-song-pageinate"></div>
            </div>
        </div>
    </div>

    {{-- MODAL AREA--}}
    @include('global_partials.modal_add_to_playlist')
@stop