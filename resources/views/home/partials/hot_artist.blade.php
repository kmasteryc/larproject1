<div class="partial-hot-song">
    <h3><i class="fa fa-music"></i> Nghệ sĩ nổi bật </h3>
    <div class="row">

        @foreach($hot_artists as $artist)
            <div class="media">
                <a class="media-left" href="#">
                    <img src="{!! asset('img/165.png') !!}" data-src="{!! $artist->artist_img_small !!}"
                         height="80px" width="80px"
                         alt="{!! $artist->artist_title !!}">
                </a>
                <div class="media-body">
                    {!! $artist->artist_title !!}
                </div>
            </div>
        @endforeach

    </div>
</div>
{{--@foreach($hot_artists as $artist)--}}
    {{--<div class="col-xs-4 col-sm-3 col-md-3 col-lg-2">--}}
        {{--<div class="thumbnail thumbnail-artist">--}}
            {{--<img src="{!! asset('img/165.png') !!}" data-src="{!! $artist->artist_img_small !!}"--}}
                 {{--height="100px" width="100px"--}}
                 {{--alt="{!! $artist->artist_title !!}">--}}
            {{--<div class="caption">--}}
                {{--<h5>--}}
                    {{--<a href="{!! url("artist/$artist->id") !!}">--}}
                        {{--{!! $artist->artist_title !!}--}}
                    {{--</a>--}}
                {{--</h5>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endforeach--}}