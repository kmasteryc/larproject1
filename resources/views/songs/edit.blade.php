@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sửa bài hát {{$song->song_title}}</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('song/'.$song->id)}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên bài hát</label>

                        <div class="col-sm-9">
                            <input type="text" name="song_title" class="form-control" value="{{$song->song_title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thể loại</label>

                        <div class="col-sm-9">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc',$song->cate_id)!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="div_box_artist">
                        <label class="col-sm-3 control-label">Nghệ sĩ</label>
                        <input type="hidden" name="song_artists" id="song_artists" value="{{$song->str_artists()}}">
                        <div class="col-sm-9 relative">
                            <div class="" id="div_artists">
                                @foreach($song->artists as $artist)
                                <a href="#"
                                    class="a_remove_artist"
                                    data-id="{{$artist->id}}">
                                    {{$artist->artist_title}}
                                     <span class="fa fa-close"></span>
                                </a>   
                                    @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tìm nghệ sĩ</label>

                        <div class="col-sm-9 relative">
                            <input type="text" class="form-control" id="input_artists">
                            <div class="popup search_artist"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">MP3 cũ</label>
                        <div class="col-sm-9">
                            <audio controls>
                                <source src="{{$song->song_mp3}}">
                            </audio>
                            <input type="text" class="form-control" value="{{$song->song_mp3}}" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Upload MP3 mới</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="uploaded_mp3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>

                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-success">
                                Sửa bài hát
                            </button>
                            <a href="{{url('song')}}" class="btn btn-info">Hủy</a>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@stop
