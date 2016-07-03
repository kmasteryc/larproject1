@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9" style="position: relative">
                <div class="row" id="playlist-summary">
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <img src="{!! $playlist->image->image_path !!}" alt="" height="165px" width="165px">

                    </div>
                    <div class="col-md-9 col-lg-9 col-sm-9">
                        <h4>{!! $playlist->playlist_title !!}</h4>
                        <div class="playlist-detail">
                            <h5>Nghệ sĩ: {!! $playlist->user->name !!}</h5>
                            <h5>Phát hành: {!! $playlist->created_at->format('m/Y') !!}</h5>
                            <h5>Thể loại: {!! $playlist->cate->cate_title !!}</h5>
                            <h5>Lượt nghe: {!! $playlist->playlist_view !!}</h5>
                            <?php $playlist_info = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque blanditiis consequuntur, id illum itaque libero maiores, molestias mollitia nihil odio officiis perspiciatis, quam qui quis quod reprehenderit sapiente similique sunt'; ?>

                            <span class="playlist-info-hidden" style="display: none">{!! $playlist_info !!}</span>
                            <span class="playlist-info">{!! str_limit($playlist_info,200) !!}</span>

                            @if(strlen($playlist_info)>=200)
                                <a href="#" id="show-playlist-info">Xem thêm</a>
                            @endif
                        </div>
                    </div>
                </div>
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
                {{--TOOL ROW--}}

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
