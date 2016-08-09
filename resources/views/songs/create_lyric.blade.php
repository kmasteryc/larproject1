@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Thêm lời cho bài hát {!! $song->song_title !!}</h3>
            </div>
            <div class="panel-body">

                <form action="{!! url("song/$song->id/lyric/") !!}" method="post" class="form-horizontal" role="form">
                    {!! csrf_field() !!}

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
                        <textarea name="lyric_content" rows="30" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="checkbox" name="lyric_has_time"> Lời bài hát có thời gian?
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop
