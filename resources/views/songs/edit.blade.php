@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Them bai hat moi</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('song/'.$song->id)}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten bai hat</label>

                        <div class="col-sm-10">
                            <input type="text" name="song_title" class="form-control" value="{{$song->song_title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">The loai</label>

                        <div class="col-sm-10">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc',$song->cate_id)!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="div_box_artist">
                        <label class="col-sm-2 control-label">Nghe si</label>
                        <input type="hidden" name="song_artists" id="song_artists" value="{{$song->str_artists()}}">
                        <div class="col-sm-10 relative">
                            <div class="" id="div_artists">
                                @foreach($song->artists as $artist)
                                    <a href="#" class="badge a_remove_artist" data-id="{{$artist->id}}">{{$artist->artist_title}}</a>
                                    @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tim nghe si</label>

                        <div class="col-sm-10 relative">
                            <input type="text" class="form-control" id="input_artists">
                            <div class="popup search_artist"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Old mp3</label>
                        <div class="col-sm-10">
                            <audio controls>
                                <source src="{{$song->song_mp3}}">
                            </audio>
                            <input type="text" class="form-control" value="{{$song->song_mp3}}" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">New mp3 file</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="uploaded_mp3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                Sua bai hat
                            </button>
                            <a href="{{url('song')}}" class="btn btn-info">Back</a>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@stop