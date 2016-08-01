@inject('khelper','Tools\Khelper')

<ul class="list-group" id="chart-song-box">
<?php $i=1; ?>
    @foreach($songs as $song)

            <li class="list-group-item">

                <div class="media ">

                    <div class="media-left media-middle">
                        <img src="{!! $song->song_artist_img !!}" style="width: 64px; height: 64px;">
                    </div>

                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="{!! url("bai-hat/$song->song_title_slug.html") !!}" class="block">
                                {!! $i++.'. '.$song->song_title !!}
                            </a>
                        </h4>
                        <a href="{!! url('nghe-si/'.$song->song_artist_title_slug.'.html') !!}">{!! $song->song_artist !!}</a>
                    </div>

                    <div class="media-right media-middle chart-item-right">
                        <a href="{!! $song->song_mp3 !!}"><i class="fa fa-download"></i></a>
                    </div>
                    <div class="media-right media-middle chart-item-right">
                        <a href="#" class="fa fa-plus" data-songid="{!! $song->song_id !!}"
                           data-songtitle="{!! $song->song_title !!}"
                           data-songartist="{!! $song->song_artist !!}"
                        ></a>
                    </div>

                    <div class="media-right media-middle chart-item-right">
                        {!! $khelper::readbleNumber($song->song_view_count) !!}
                    </div>

                </div>
            </li>


    @endforeach

</ul>