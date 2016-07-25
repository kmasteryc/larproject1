@extends('layouts.app')

@section('content')
        <div class="col-md-9">
            <div class="row">
            <div class="col-md-12">
                <ul class="pgwSlider">
                    @foreach($new_songs as $song)
                        <li>
                            <a href="{!! url('song/'.$song->id) !!}" target="_blank">
                                <img src="{!! $song->song_img !!}">
                                {{--<img src="http://image.mp3.zdn.vn/banner/1/b/1b2416fbb471d846e876c5e1dd0b32eb_1469076901.jpg" height="120%">--}}
                                <span>{!! $song->song_title !!} - {!! $song->artists->first()->artist_title !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                Hot album
            </div>
                </div>

            <div class="row">
            <div class="col-md-12">
                Hot artist
            </div>
                </div>

        </div>
        <div class="row-md-3">
            Topic modules
            Chart modules
        </div>
@endsection
