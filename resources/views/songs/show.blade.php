@inject('khelper','Tools\Khelper')
@extends('layouts.app')
@section('content')
    <script>
        var player_config = {
            mode : 1,
            api_url: '{!! $api_url !!}'
        };
    </script>
    <div class="container">

        <div class="row">
            <div class="col-md-9">
                <div class="content">
                    <h4>
                        {!! $song->song_title !!} - {!! $song->song_artists_title !!}
                    </h4>

                    @include('standalones.player')

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
