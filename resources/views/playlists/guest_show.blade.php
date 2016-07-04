@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9" style="position: relative">
                <div class="row" id="playlist-summary">
                    <h4>Danh sách nhạc tạm thời của bạn</h4>
                    <h5>Danh sách tự động xóa sau 1 ngày</h5>
                    <h5>Hãy đăng nhập để lưu lại danh sách</h5>
                </div>

                @if (session()->get('temp_playlist'))
                <div class="row" id="temp_playlist_tool">
                    <!-- Split button -->
                    <div class="col-md-12">

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" id="import-temp-playlist">Nhập vào danh sách khác</button>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" id="delete-temp-playlist">Xóa danh sách tạm</button>
                        </div>

                    </div>
                </div>
                @endif

                <script>
                    var player_config = {
                        api_url: '{!! $api_url !!}',
                        mode: 2
                    };
                </script>
                @include('standalones.player')
                {{--TOOL ROW--}}

            </div>
            <div class="col-md-3">

            </div>
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
        </div>
    </div>
@stop
