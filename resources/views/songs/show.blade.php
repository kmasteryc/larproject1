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
                            <h4>{!! $song->song_title !!}</h4>
                        </div>
                        <div class="pull-right">
                            <h4><i class="fa fa-music fa-1x"> {!! $song->song_view !!}</i></h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{--@todo: Song tool module--}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="lyric-area">

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

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
    <div class="modal" id="song-popup" tabindex="-1" role="dialog">
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
