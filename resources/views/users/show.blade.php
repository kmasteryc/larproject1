@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9" style="position: relative">
                <div class="row" id="playlist-summary">
                    <div class="col-md-3">
                        <img src="{!! $playlist->image->image_path !!}" alt="">
                    </div>
                    <div class="col-md-9">
                        <h4>PLAYLIST: {!! $playlist->playlist_title !!}</h4>
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
                <div class="content">
                    <h4>
                        GỢI Ý
                    </h4>
                </div>
            </div>
        </div>
    </div>
@stop
