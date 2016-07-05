@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <h4>Chủ đề: {!! $cate->cate_title !!}</h4>
            <h5>Album HOT</h5>
            <div class="row">
                <ul class="lightSlider">
                    @foreach ($playlists as $pl)
                        <?php
                        $img = $pl->image->image_path;
                        ?>
                        <li>
                            <a href="{!! url('playlist/'.$pl->id) !!}">
                                <div class="playlist-box">
                                    <div class="playlist-img">
                                        <span class="play-hover">
                                            <i class="fa fa-3x fa-play-circle-o"></i>
                                        </span>
                                        <img src="{!! $img !!}" height="165px" width="165px">
                                    </div>
                                    <p class="playlist-title">
                                        {!! $pl->playlist_title !!}
                                        <i class="playlist-artist">
                                            {!! $pl->user->name !!}
                                        </i>
                                    </p>
                                </div>
                            </a>
                        </li>
                    @endforeach

                </ul>

            </div>
            <h5>Bài hát HOT</h5>
            <div class="row">
                <script> var cate = '{!! $cate->id !!}';</script>
                <div style="text-align: center" id="hot-song-pageinate"></div>
                <ul class="list-group" id="hot-song"></ul>
            </div>
        </div>
    </div>
@stop