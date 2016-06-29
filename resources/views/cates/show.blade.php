@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <h4>Chủ đề: {!! $cate->cate_title !!}</h4>
            <h5>Album HOT</h5>
            <div class="row">
                @foreach ($playlists as $pl)
                    <a href="{!! url('playlist/'.$pl->id) !!}">
                        <div class="col-md-3 col-lg-2 col-sm-4 col-xs-6">
                            <div class="playlist-box">
                                <span class="play-hover">
                                    <i class="fa fa-3x fa-play-circle-o"></i>
                                </span>
                                {{--<img src="{!! //$pl->image->image_path !!}" alt="">--}}
                                <img src="http://image.mp3.zdn.vn/thumb/165_165/covers/1/5/15171a8058de99f758a61554225d4f72_1446524127.jpg" alt="">
                                <p class="playlist-title">
                                    {!! $pl->playlist_title !!}
                                    <i class="playlist-artist">
                                        {!! $pl->user->name !!}
                                    </i>
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <h5>Bài hát HOT</h5>
            <div class="row">
                <ul class="list-group hot-song">
                @foreach ($songs as $song)
                    	<li class="list-group-item">
                           <span class="pull-left"><a href="{!! url('song/'.$song->id) !!}">{!! $song->song_title !!}</a> - {!! $song->song_artists_title !!}</span>
                           <span class="pull-right">Some action here!</span>
                            <div class="clearfix"></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop