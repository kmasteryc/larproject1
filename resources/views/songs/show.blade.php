@extends('layouts.app')
@section('content')
<div class="container">
    <script>
        lyric = `{!! $song->lyrics[0]['lyric_content'] !!}`;
    </script>
    {{--
    <script>
        lyric = "2";
    </script>
    --}}
    <div class="row">
        <div class="col-md-8">
            <div class="content">
                <h4>
                    {!! $song->song_title !!} - {!! $song->song_artists_title !!}
                </h4>
                <div class="buildin-player">
                    <audio controls="controls" id="player">
                        <source src="{!! $song->song_mp3 !!}">
                        </source>
                    </audio>
                </div>
                <div id="my-player">
                    <div class="player-background">
                    </div>
                    <div class="player-mask">
                    </div>
                    <div class="lyric-bar">
                        <div class="lyric">
                            <p class="lyric-1">
                            </p>
                        </div>
                        <br/>
                        <div class="lyric">
                            <p class="lyric-2">
                            </p>
                        </div>
                    </div>
                    <div class="seek-bar">
                        <input class="bar" id="seek" type="range" value="0"/>
                    </div>
                    <div class="control-bar">
                        <div class="player-button">
                            <i class="fa fa-2x fa-play">
                            </i>
                            <i class="fa fa-2x fa-volume-up volume">
                            </i>
                            <span class="volume-bar">
                                <input class="bar" id="volume" type="range" value="90"/>
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
            </div>
        </div>
        <div class="col-md-4">
            <div class="content">
                <h4>
                    GỢI Ý
                </h4>
            </div>
        </div>
    </div>
</div>
@stop
