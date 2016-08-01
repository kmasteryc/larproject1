<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

        <?php $i = 1; ?>
        @foreach($new_songs as $song)
            <div class="item {!! $i==1 ? 'active' : '' !!}">
                <a href="{!! url("bai-hat/$song->song_title_slug.html") !!}">
                    <img data-src="{!! $song->song_img !!}" src="{!! asset('img/850.png') !!}">
                    <div class="carousel-caption">
                        {!! $song->song_title !!}
                    </div>
                </a>
            </div>

            <?php $i++ ?>
        @endforeach

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>

</div>