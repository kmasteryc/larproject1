@inject('khelper','Tools\Khelper')

<ul class="list-group" id="chart-song-box">
<?php $i=1; ?>
    @foreach($albums as $album)

            <li class="list-group-item">

                <div class="media ">

                    <div class="media-left media-middle">
                        <img src="{!! $album->playlist_img !!}" style="width: 64px; height: 64px;">
                    </div>

                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="{!! url('playlist/'.$album->playlist_title_slug.'.html') !!}" class="block">
                                {!! $i++.'. '.$album->playlist_title !!}
                            </a>
                        </h4>
                        <a href="{!! url('nghe-si/'.$album->playlist_artist_title_slug.'.html') !!}">
                            {!! $album->playlist_artist !!}
                        </a>
                    </div>

                    <div class="media-right media-middle chart-item-right">
                        {!! $khelper::readbleNumber($album->playlist_view_count) !!}
                    </div>

                </div>
            </li>


    @endforeach

</ul>