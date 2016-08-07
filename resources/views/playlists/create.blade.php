@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Thêm danh sách nhạc mới</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('playlist/store')}}" method="POST" class="form-horizontal" role="form"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên danh sách</label>

                        <div class="col-sm-9">
                            <input type="text" name="playlist_title" class="form-control"
                                   value="{{old('playlist_title')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nghệ sĩ thể hiện</label>

                        <div class="col-sm-9">
                            <select name="artist_id" id="" class="form-control">
                                <option value="0">Nhiều ca sĩ</option>
                                @foreach ($artists as $artist)
                                    <option value="{!! $artist->id !!}">{!! $artist->artist_title !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thể loại</label>

                        <div class="col-sm-9">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc',old('playlist_cate'))!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vài dòng giới thiệu</label>

                        <div class="col-sm-9">
                            <textarea name="playlist_info" class="form-control">{{old('playlist_info')}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ảnh </label>

                        <div class="col-sm-9">
                            <input type="file" name="playlist_img" class="form-control">
                        </div>
                    </div>

                    <div class="form-group fog" id="div_box_song">
                        <label class="col-sm-3 control-label">Bài hát đã chọn</label>
                        <input type="hidden" name="playlist_songs" id="playlist_songs">
                        <div class="col-sm-9 relative">
                            <div class="" id="div_songs">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tìm bài hát</label>

                        <div class="col-sm-9 relative">
                            <input type="text" class="form-control" id="input_songs">
                            <div class="popup search_song"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>

                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-success">Tạo danh sách nhạc</button>
                            <a href="{{url('playlist')}}" class='btn btn-danger'>Hủy</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop
