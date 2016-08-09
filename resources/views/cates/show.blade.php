@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">

            <h3>Album {!! $cate->cate_title !!}</h3>
            <div class="row thumbnail-row">
                @foreach($hot_playlists as $playlist)
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="thumbnail">
                            <img src="{!! $playlist->playlist_img !!}" alt="{!! $playlist->playlist_title !!}">
                            <div class="caption">
                                <h5>
                                    <a href="{!! url("playlist/".$playlist->playlist_title_slug.".html") !!}">
                                        {!! $playlist->playlist_title !!}
                                    </a>
                                </h5>
                                <a href="{!! url("nghe-si/".$playlist->artist->artist_title_slug.".html") !!}">
                                    {!! $playlist->artist->artist_title !!}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div style="text-align: center" id="hot-album-pageinate">{!! $hot_playlists->links() !!}</div>
            </div>

            <h3>Bài hát {!! $cate->cate_title !!}</h3>
            <div class="row">
                @foreach($hot_songs as $song)
                    <li class="list-group-item">
                        <div class="clearfix">
                    <span class="pull-left">
                        <a href="{!! url("bai-hat/".$song->song_title_slug.".html") !!}">
                            {!! $song->song_title !!}
                        </a> - ${renderArtists(songs[x].artists)}
                        </a>
                     </span>
                    <span class="pull-right">
                        <a href="#">
                        <i class="fa fa-plus"
                           data-songid="{!! $song->id !!}"
                           data-songtitle="{!! $song->song_title !!}"
                           data-songartist="{!! $song->artists[0]->artist_title !!}"></i>
                        </a>
                        <a href="{!! $song->song_mp3 !!}"><i class="fa fa-download"></i></a>
                    </span>
                        </div>
                    </li>
                @endforeach
            </div>
            <div class="row">
                <div style="text-align: center" id="hot-song-pageinate">
                    {!! $hot_songs->links() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL AREA--}}
    @include('global_partials.modal_add_to_playlist')
@stop