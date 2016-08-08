@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')
    @include('global_partials.load_fb_sdk')
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
                @include("global_partials.like_btn")
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group" id="player-playlist"></ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="lyric-area">

                        </div>
                    </div>
                </div>

                @include("global_partials.facebook_comment")

            </div>
            <div class="col-md-4">
                <div class="row" id="playlist-summary">

                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="http://dummyimage.com/100/1abc9c/ffffff&text={!! 'BXH '.$timeinfo['time_unit'].'+'.$timeinfo['index'] !!}"
                                 height="100px" width="100px">
                        </a>
                        <div class="media-body">
                            <h4>BẢNG XẾP
                                HẠNG {!! $cate->cate_title !!} {!! $timeinfo['time_unit'] !!} {!! $timeinfo['index'] !!}
                                ({!! $timeinfo['start_date'] !!} - {!! $timeinfo['end_date'] !!})
                            </h4>
                            <div class="playlist-detail">
                                Bảng xếp hạng được tạo tự động dựa trên số lượng lượt nghe trong từng khoảng thời gian.
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="playlist-detail">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="other-playlist">
                            <h4><i class="fa fa-bookmark"></i> BXH KHÁC</h4>

                            <?php
                            for ($i = 1; $i <= $timeinfo['cur_real_index']; $i++) {
                                $bxh[] = $i;
                            }
                            $max = count($bxh) < 3 ? count($bxh) : 3;
                            $bxh_rand = array_rand($bxh, $max);
                            ?>
                            @foreach($bxh_rand as $bxh)
                                <a href="{!! url("bang-xep-hang/$cate->cate_title_slug/".str_slug($timeinfo['time_unit'])."-$bxh/play.html") !!}">
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img class="media-object"
                                                 src="http://dummyimage.com/165/1abc9c/ffffff&text={!! 'BXH '.$timeinfo['time_unit'].'+'.$bxh !!}"
                                                 height="80px"
                                                 width="auto">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-media-heading">
                                                BẢNG XẾP HẠNG {!! $cate->cate_title !!}
                                                {!! $timeinfo['time_unit'] !!} {!! $bxh !!}
                                            </h5>
                                            <p>Various Artists</p>
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
