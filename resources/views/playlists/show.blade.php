@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')
    <div class="container">
        <?php
        $song = $songs[$index['cur_index']];
        ?>
        <script>
            var pre_config_player = [];
            pre_config_player['prev_url'] = '{!! $url['prev_url'] !!}';
            pre_config_player['next_url'] = '{!! $url['next_url'] !!}';
            pre_config_player['next_index'] = '{!! $index['next_index'] !!}';
            // 0-not loop; 1-loop current song; default is loop playlist
            pre_config_player['mode'] = '{!! $mode !!}';
            pre_config_player['volume'] = '{!! $volume !!}';
            @if (@count($song->lyrics) !== 0)
                    pre_lyric = `{!! @$song->lyrics[0]['lyric_content'] !!}`;
            @else
                    pre_lyric = 0;
            @endif

        </script>
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
                <div class="row">
                    <div class="col-md-12">
                        <div id="buildin-player">
                            <audio controls="controls" id="player" autoplay {!! $mode == 1 ? 'loop' : '' !!}>
                                <source src="{!! @$song->song_mp3 !!}">
                                </source>
                            </audio>
                        </div>
                    </div>
                </div>
                {{--PLAYER--}}
                <div id="my-player">
                    <div class="player-background"></div>
                    <div class="player-mask"></div>
                    <div class="lyric-bar">
                        <div class="lyric">
                            <p class="lyric-1">
                                {!! @$song->song_title !!}
                            </p>
                        </div>
                        <br/>
                        <div class="lyric">
                            <p class="lyric-2">
                                {!! @$song->song_artists_title_text !!}
                            </p>
                        </div>
                    </div>
                    <div class="seek-bar">
                        <input class="bar" id="seek" type="range" value="0"/>
                    </div>
                    <div class="control-bar">
                        <div class="player-button">
                            <a href="{!! $url['prev_url'] !!}">
                                <i class="fa fa-2x fa-step-backward"></i>
                            </a>
                            <i class="fa fa-2x fa-pause"></i>
                            <a href="{!! $url['next_url'] !!}">
                                <i class="fa fa-2x fa-step-forward"></i>
                            </a>
                            <i class="fa fa-2x fa-volume-up volume">
                            </i>
                            <span class="volume-bar">
                                <input class="bar" id="volume" type="range" value="{!! $volume*100 !!}"/>
                            </span>
                            <span class="process-bar">
                                <span class="current-time"></span>/<span class="duration"></span>
                            </span>
                            @if($mode==1)
                                <i class="fa fa-1x fa-thumb-tack"> Lặp bài này</i>
                            @elseif($mode==2)
                                <i class="fa fa-1x fa-refresh"> Lặp toàn bộ</i>
                            @elseif($mode==3)
                                <i class="fa fa-1x fa-random"> Ngẫu nhiên</i>
                            @endif

                        </div>
                    </div>
                </div>

                {{--TOOL ROW--}}


                {{--PLAYLIST--}}
                <ul class="list-group" id="player-playlist">
                    @foreach ($songs as $k=>$l_song)
                        <li class="list-group-item {!! $k==$index['cur_index']?'list-group-item-info':'' !!}">
                                    <span class="pull-left">
                                        {!! $k+1 !!}.
                                        <a href="{!! url("playlist/$playlist->id/$k") !!}">{!! $l_song->song_title !!}</a> - {!! $l_song->song_artists_title !!}
                                    </span>
                                    <span class="pull-right">
                                        <a href="{!! $l_song->song_mp3 !!}}}"><i class="fa fa-download"></i></a>
                                        <i class="fa fa-plus"></i>
                                        <i class="fa fa-arrow-right"></i>
                                    </span>
                            <div class="clearfix"></div>
                        </li>
                    @endforeach
                </ul>
                {{--LYRIC AREA--}}

                @if (@count($song->lyrics) !== 0)
                    <div class="well" id="lyric-area">
                        {!! $khelper::readbleLyric($song->lyrics[0]['lyric_content']) !!}
                    </div>
                @endif
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
