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
                                mode: 2
                            };
                        </script>
                        @include('standalones.player')
                    </div>
                </div>

                <div class="row" id="middle-info">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4>{!! $playlist->playlist_title !!}</h4>
                            @include("global_partials.like_btn")
                        </div>
                        <div class="pull-right">
                            <h4><i class="fa fa-music fa-1x"> {!! $playlist->playlist_view !!}</i></h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group" id="player-playlist"></ul>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div id="lyric-area">
                            <div id="lyric-btn">

                            </div>
                            <div id="lyric-content">

                            </div>
                        </div>
                    </div>
                </div>

                @include("global_partials.facebook_comment")

            </div>
            <div class="col-md-4">
                <div class="row" id="playlist-summary">
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="{!! $playlist->playlist_img !!}" height="100px" width="100px">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{!! $playlist->playlist_title !!}</h4>
                            <h5>Nghệ sĩ: {!! $playlist->artist->artist_title !!}</h5>
                            <h5>Phát hành: {!! $playlist->created_at->format('m/Y') !!}</h5>
                            {{--<h5>Thể loại: {!! $playlist->cate->cate_title !!}</h5>--}}
                            {{--<h5>Upload: {!! $playlist->user->name !!}</h5>--}}
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="playlist-detail">

                            <span class="playlist-info-hidden"
                                  style="display: none">{!! $playlist->playlist_info !!} <a href="#"
                                                                                            id="hide-playlist-info">Ẩn đi</a></span>
                            <span class="playlist-info">{!! str_limit($playlist->playlist_info,200) !!}

                                @if(strlen($playlist->playlist_info)>=200)
                                    <a href="#" id="show-playlist-info">Xem thêm</a>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="other-playlist">
                            <h4><i class="fa fa-bookmark"></i> Playlist tương tự</h4>
                            @foreach($other_playlists as $other_playlist)
                                <a href="{!! url("playlist/$other_playlist->playlist_title_slug.html") !!}">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img class="media-object"
                                                 src="{!! $other_playlist->playlist_img !!}" height="80px"
                                                 width="auto">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-media-heading">{!! $other_playlist->playlist_title !!}</h5>
                                            <p>{!! $other_playlist->artist->artist_title !!}</p>
                                            <p><i class="fa fa-music"></i> {!! $other_playlist->playlist_view !!}</p>
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
    <div class="modal" id="playlist-popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title" id="myModalLabel"> Thêm vào danh sách</h4>
                </div>
                <div class="modal-body">
                    <span id="add-song-alert"></span>
                    <ul class="list-group">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@stop
