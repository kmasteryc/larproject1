@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sửa lời bài hát {!! $song->song_title !!}</h3>
            </div>
            <div class="panel-body">

                <form action="{!! url("song/lyric/$lyric->id") !!}" method="post" class="form-horizontal" role="form">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <div class="form-group">
                        <label class="col-sm-3" for="">Bài hát</label>
                        <div class="col-sm-9">
                            <audio controls>
                                <source src="{{$song->song_mp3}}">
                            </audio>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3" for="">Lời bài hát</label>
                        <div class="col-sm-9">
                        <textarea name="lyric_content" rows="30" class="form-control">{!! $lyric->lyric_content !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="checkbox" name="lyric_has_time" {!! $lyric->lyric_has_time == 1 ? 'checked' : '' !!}> Lời bài hát có thời gian?
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary">Sửa</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop
