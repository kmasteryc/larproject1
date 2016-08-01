@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div id="artist-header" style="
                background: url('{!! $artist->artist_img_cover !!}');
                background-size:     cover;
                background-repeat:   no-repeat;
                background-position: center center;
                ">
            <div class="float-container">
                <div class="media">
                    <a class="media-left" href="#">
                        <img src="{!! $artist->artist_img_small !!}" height="165px" width="165px">
                    </a>
                    <div class="media-body media-bottom">
                        <h4 class="media-heading">{!! $artist->artist_title !!} ({!! $artist->artist_name !!})</h4>
                        Ngày sinh: {!! $artist->artist_birthday !!} <br/>
                        Quốc gia: {!! $artist->artist_nation !!}
                    </div>
                </div>

            </div>
        </div>
        <div id="artist-main">
            <ul class="nav nav-pills" id="artist-tabs">
                <li role="presentation" class="active"><a href="#tieusu">Tiểu sử</a></li>
                <li role="presentation"><a href="#album">Album</a></li>
                <li role="presentation"><a href="#baihat">Bài hát</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tieusu">
                    {!! $artist->artist_info !!}
                </div>
                <script>var artist = '{!! $artist->id !!}';</script>
                <div role="tabpanel" class="tab-pane" id="album">
                    <div class="thumbnail-row">
                        @foreach($playlists as $playlist)
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="thumbnail">
                                    <img src="{!! $playlist->playlist_img !!}"
                                         alt="{!! $playlist->playlist_title !!}">
                                    <div class="caption">
                                        <h5>
                                            <a href="{!! url("playlist/$playlist->playlist_title_slug.html") !!}">
                                                {!! $playlist->playlist_title !!}
                                            </a>
                                        </h5>
                                        <a href="{!! url("artist/".$playlist->artist->id) !!}">
                                            {!! $playlist->artist->artist_title !!}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="baihat">
                    <ul class="list-group" id="hot-song"></ul>
                    <div style="text-align: center" id="song-paginate"></div>
                </div>
            </div>
        </div>
    </div>
@stop