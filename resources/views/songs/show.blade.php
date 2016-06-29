@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')
    <div class="container">
        <script>
            var pre_config_player = [];
            // 0-not loop; 1-loop current song; default is loop playlist
            pre_config_player['mode'] = '{!! $mode !!}';
            pre_config_player['volume'] = '{!! $volume !!}';
            @if (count($song->lyrics) !== 0)
                    pre_lyric = `{!! $song->lyrics[0]['lyric_content'] !!}`;
            @else
                    pre_lyric = 0;
            @endif
        </script>
        <div class="row">
            <div class="col-md-9">
                <div class="content">
                    <h4>
                        {!! $song->song_title !!} - {!! $song->song_artists_title !!}
                    </h4>
                    <div id="buildin-player">
                        <audio controls="controls" id="player" autoplay loop>
                            <source src="{!! $song->song_mp3 !!}">
                            </source>
                        </audio>
                    </div>
                    <div id="my-player">
                        <div class="player-background"></div>
                        <div class="player-mask"></div>
                        <div class="lyric-bar">
                            <div class="lyric">
                                <p class="lyric-1">
                                    {!! $song->song_title !!}
                                </p>
                            </div>
                            <br/>
                            <div class="lyric">
                                <p class="lyric-2">
                                    {!! $song->song_artists_title_text !!}
                                </p>
                            </div>
                        </div>
                        <div class="seek-bar">
                            <input class="bar" id="seek" type="range" value="0"/>
                        </div>
                        <div class="control-bar">
                            <div class="player-button">
                                <i class="fa fa-2x fa-pause">
                                </i>
                                <i class="fa fa-2x fa-volume-up volume">
                                </i>
                            <span class="volume-bar">
                                <input class="bar" id="volume" type="range" value="{!! $volume*100 !!}"/>
                            </span>
                            <span class="process-bar">
                                <span class="current-time">
                                </span>
                                /
                                <span class="duration">
                                </span>
                            </span>
                            </div>
                        </div>

                    </div>
                    {{--TOOL ROW--}}
                    <div id="player-tool-area">

                        <span class="tool-box">
                        <i>{{$song->song_view}}</i>
                            <b>Lượt nghe</b>
                        </span>
                        <div class="clearfix"></div>

                        <span class="tool-box">
                        <i class="fa fa-2x fa-plus"></i>
                            <b>Thêm vào</b>
                        </span>
                        <div class="clearfix"></div>

                        <a href="{{$song->song_mp3}}">
                        <span class="tool-box">

                            <i class="fa fa-2x fa-download"></i>
                            <b>Tải xuống</b>

                        </span>
                        </a>
                        <div class="clearfix"></div>

                    </div>


                    {{--LYRIC AREA--}}

                    @if (@count($song->lyrics) !== 0)
                        <div class="clearfix"></div>
                        <div class="well" id="lyric-area">
                            <div id="lyric-info">Đóng góp lyric</div>
                            @if (@count($song->lyrics) > 1)
                                <div id="lyric-tool">

                                    Các phiên bản:
                                    @foreach ($song->lyrics as $kl => $vl)
                                        <a class="next-lyric" data-cur="{!! $kl !!}" data-total="{!! count($song->lyrics) !!}" href="#">{{$kl+1}}</a>
                                        <span class="hidden hidden-lyric-{!! $kl !!}">{!! $khelper::readbleLyric($song->lyrics[$kl]['lyric_content']) !!}</span>
                                    @endforeach
                                    <i class="fa fa-thumbs-up"></i>
                                </div>
                            @endif
                            <span class="lyric-default">{!! $khelper::readbleLyric($song->lyrics[0]['lyric_content']) !!}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="content">
                    <h4>
                        CÓ THỂ BẠN MUỐN NGHE
                    </h4>
                </div>
            </div>
        </div>
    </div>
@stop
