@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">

            <h3><i class="fa fa-music"></i> Bài hát {!! $cate->cate_title !!}</h3>
            <div class="row">
                @foreach($hot_songs as $song)
                    <div class="col-md-6">
                        <li class="list-group-item">
                            <div class="clearfix">
                    <span class="pull-left">
                        <a href="{!! url("bai-hat/".$song->song_title_slug.".html") !!}">
                            <b>{!! $song->song_title !!}</b>
                        </a> <br/> <a
                                href="{!! url("nghe-si/".$song->artists[0]->artist_title_slug.".html") !!}">{!! $song->artists[0]->artist_title !!}
                        </a> <i class="fa fa-headphones"> {!! $song->views()->sum('view_count') !!}</i>
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
                    </div>
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