@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Thêm bài hát mới</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('song/store')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên bài hát</label>

                        <div class="col-sm-9">
                            <input type="text" name="song_title" class="form-control" value="{{old('song_title')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thể loại</label>

                        <div class="col-sm-9">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc')!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group fog" id="div_box_artist">
                        <label class="col-sm-3 control-label">Nghệ sĩ</label>
                        <input type="hidden" name="song_artists" id="song_artists">
                        <div class="col-sm-9 relative">
                            <div class="" id="div_artists">
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
                        <label class="col-sm-3 control-label">Upload MP3</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="uploaded_mp3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lời bài hát</label>
                        <div class="col-sm-9">
                            <textarea name="lyric_content" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input type="checkbox" name="lyric_has_time"> Lời bài hát có thời gian?
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>

                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-success">
                                Thêm bài hát
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop
