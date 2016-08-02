@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8" style="position: relative">
                <div class="row">
                    <div class="col-md-12">
                        <script>
                            var player_config = {
                                api_url: '{!! $api_url !!}',
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

            </div>
            <div class="col-md-4">
                <div class="row" id="playlist-summary">

                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <img src="{!! $playlist->image->image_path !!}" alt="">
                    </div>

                    <div class="col-md-8 col-lg-8 col-sm-8">
                        <h4>{!! $playlist->playlist_title !!}</h4>
                        <div class="playlist-detail">
                            <h5>Nghệ sĩ: {!! $playlist->artist->artist_title !!}</h5>
                            <h5>Phát hành: {!! $playlist->created_at->format('m/Y') !!}</h5>
                            <h5>Thể loại: {!! $playlist->cate->cate_title !!}</h5>
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
                            <ul class="list-group">
                                @foreach($other_playlists as $other_playlist)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                                                <p class="center-block">
                                                    <img src="{!! $other_playlist->image->image_path !!}" alt="">
                                                </p>
                                            </div>
                                            <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
                                                <p class="otherpl-title">
                                                    {!! str_limit($other_playlist->playlist_title,30) !!}<br/>
                                                    {!! $other_playlist->cate_id !!}<br/>
                                                    {!! $other_playlist->artist_id !!}<br/>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
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
