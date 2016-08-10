@extends('layouts.app')
@section('content')
        <div class="col-md-12">

            <h3><i class="fa fa-list"></i> Album {!! $cate->cate_title !!}</h3>
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
        </div>
@stop