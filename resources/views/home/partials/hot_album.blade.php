<div class="partial-hot-song">
    <h3><i class="fa fa-music"></i> ALBUM HOT</h3>
    <div class="row">

        @foreach($chart_playlists as $playlist)
            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <div class="thumbnail">
                    <img src="{!! asset('img/165.png') !!}" data-src="{!! $playlist->playlist_img !!}" alt="{!! $playlist->playlist_artist !!}">
                    <div class="caption">
                        <h5>
                            <a href="{!! url("playlist/$playlist->playlist_title_slug.html") !!}">
                                {!! $playlist->playlist_title !!}
                            </a>
                        </h5>
                        <a href="{!! url("nghe-si/$playlist->playlist_artist_title_slug.html") !!}">
                            {!! $playlist->playlist_artist !!}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>