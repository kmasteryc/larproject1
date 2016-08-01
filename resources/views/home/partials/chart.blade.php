<div class="partial-chart">
    <h3>
        <a href="{!! url('bang-xep-hang/viet-nam/play.html') !!}">
        BXH BÀI HÁT <i class="fa fa-play-circle-o"></i>
        </a>
    </h3>

    @foreach($chart_songs as $song)
        <div class="media">
            <a class="media-left media-middle" href="#">
                <?php
                $i = !isset($i) ? $i = 1 : ++$i;
                switch ($i) {
                    case 1:
                        echo "<span class='label label-danger'>$i</span>";
                        break;
                    case 2:
                        echo "<span class='label label-warning'>$i</span>";
                        break;
                    case 3:
                        echo "<span class='label label-info'>$i</span>";
                        break;
                    default:
                        echo "<span class='label label-success'>$i</span>";
                        break;
                }
                ?>

            </a>
            <div class="media-body">
                <h5>
                    <a href="{!! url("bai-hat/$song->song_title_slug.html") !!}">{!! $song->song_title !!}</a>
                </h5>
                <a href="{!! url("nghe-si/$song->song_artist_title_slug.html") !!}">
                    {!! $song->song_artist !!}
                </a>
            </div>
        </div>
    @endforeach

</div>