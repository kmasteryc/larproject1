@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')
    @include("global_partials.load_fb_sdk")
    <div class="container">
        <div class="row">
            <div class="col-md-8" style="position: relative">
                <div class="row">
                    <div class="col-md-12">
                        <script>
                            var player_config = {
                                api_url_1: '{!! $api_url_1 !!}',
                                api_url_2: '{!! $api_url_2 !!}',
                                mode: 1
                            };
                        </script>
                        @include('standalones.player')
                    </div>
                </div>

                <div class="row" id="middle-info">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4>{!! $song->song_title !!} - <a href="{!! url("nghe-si/".$song->artists[0]->artist_title_slug.".html") !!}">{!! $song->artists[0]->artist_title !!}</a></h4>
                            @include('global_partials.like_btn')
                        </div>
                        <div class="pull-right">
                            <h4><i class="fa fa-music fa-1x"> {!! $song->song_view !!}</i></h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="lyric-area">

                        </div>
                    </div>
                </div>

                @include('global_partials.facebook_comment')

            </div>
            <div class="col-md-4">

                <div class="row" id="playlist-summary">
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="{!! $song->artists[0]->artist_img_small !!}" height="100px" width="100px">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Bài hát {!! $song->song_title !!}</h4>
                            <h5>Nghệ sĩ: <a href="{!! url("nghe-si/".$song->artists[0]->artist_title_slug.".html") !!}">{!! $song->artists[0]->artist_title !!}</a></h5>
                            <h5>Phát hành: {!! $song->created_at->format('m/Y') !!}</h5>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="playlist-detail">
                            <span class="playlist-info-hidden"
                                  style="display: none">{!! $song->artists[0]->artist_info !!} <a href="#"
                                                                                            id="hide-playlist-info">Ẩn đi</a></span>
                            <span class="playlist-info">{!! str_limit($song->artists[0]->artist_info,200) !!}

                                @if(strlen($song->artists[0]->artist_info)>=200)
                                    <a href="#" id="show-playlist-info">Xem thêm</a>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="other-playlist">
                            <h4><i class="fa fa-bookmark"></i> Bài hát cùng chủ đề</h4>
                            @foreach($other_songs as $other_song)
                                <a href="{!! url("bai-hat/$other_song->song_title_slug.html") !!}">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img class="media-object"
                                                 src="{!! $other_song->artists[0]->artist_img_small !!}" height="80px"
                                                 width="auto">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-media-heading">{!! $other_song->song_title !!}</h5>
                                            <p>{!! $other_song->artists[0]->artist_title !!}</p>
                                            <p><i class="fa fa-music"></i> {!! $other_song->song_view !!}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('global_partials.modal_add_to_playlist')
@stop
