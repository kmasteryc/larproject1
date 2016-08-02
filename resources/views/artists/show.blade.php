@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div id="artist-header">
            <div class="container">
                {{--<h1>Hello, world!</h1>--}}
                <p id="artist-avatar"><img src="http://placehold.it/150x150" alt=""></p>
            </div>
        </div>
        <div id="artist-main">
            <ul class="nav nav-pills" id="artist-tabs">
                <li role="presentation" class="active"><a href="#tieusu">Tiểu sử</a></li>
                <li role="presentation"><a href="#album">Album</a></li>
                <li role="presentation"><a href="#baihat">Bài hát</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tieusu">
                    {!! $artist->artist_info !!}
                </div>
                <script>var artist = '{!! $artist->id !!}';</script>
                <div role="tabpanel" class="tab-pane" id="album">
                    <ul class="list-group" id="list-album"></ul>
                    <div style="text-align: center" id="album-paginate"></div>
                </div>
                <div role="tabpanel" class="tab-pane" id="baihat">
                    <ul class="list-group" id="list-song"></ul>
                    <div style="text-align: center" id="song-paginate"></div>
                </div>
            </div>
        </div>
    </div>
@stop