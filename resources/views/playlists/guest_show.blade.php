@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')
    <div class="col-md-8" style="position: relative">
        <div class="row">
            <div class="col-md-12">
                <div id="playlist-summary">
                    @if(session()->has('temp_playlist') && session()->get('temp_playlist')['total_songs'] != 0)
                        <h4>Danh sách nhạc tạm thời của bạn</h4>
                        <h5>Danh sách tự động xóa sau 1 ngày</h5>
                        <h5>Hãy đăng nhập để lưu lại danh sách</h5>

                        <div id="temp_playlist_tool">
                            <!-- Split button -->

                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"
                                        id="import-temp-playlist">Nhập vào danh sách khác
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"
                                        id="delete-temp-playlist">Xóa danh sách tạm
                                </button>
                            </div>

                        </div>

                    @else
                        <div class="col-md-12">
                            <div class="row">
                                <h4>Danh sách nhạc tạm thời của bạn</h4>
                                <h5>Danh sách trống. Vui lòng thêm bài hát</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <script>
                    var player_config = {
                        api_url_1: '{!! $api_url_1 !!}',
                        api_url_2: '{!! $api_url_2 !!}',
                        mode: 2,
                        temp_playlist: true
                    };
                </script>
                @include('standalones.player')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group" id="player-playlist"></ul>
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div id="other-playlist">
            <h4><i class="fa fa-bookmark"></i> Playlist ngẫu nhiên</h4>
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
                            <p>
                                <i class="fa fa-music"></i> {!! $other_playlist->views()->sum('view_count') !!}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="modal" id="playlist-popup" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title" id="myModalLabel"> Nhập vào danh sách</h4>
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
@stop
