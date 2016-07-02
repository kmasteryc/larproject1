@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Them danh sach nhac moi</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('playlist/store')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten danh sach</label>

                        <div class="col-sm-10">
                            <input type="text" name="playlist_title" class="form-control" value="{{old('playlist_title')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">The loai</label>

                        <div class="col-sm-10">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc',old('playlist_cate'))!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Anh </label>

                        <div class="col-sm-10">
                            <input type="file" name="playlist_img" class="form-control">
                        </div>
                    </div>

                    <div class="form-group fog" id="div_box_song">
                        <label class="col-sm-2 control-label">Bai hat</label>
                        <input type="hidden" name="playlist_songs" id="playlist_songs">
                        <div class="col-sm-10 relative">
                            <div class="" id="div_songs">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tim bai hat</label>

                        <div class="col-sm-10 relative">
                            <input type="text" class="form-control" id="input_songs">
                            <div class="popup search_song"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Them danh sach nhac</button>
                            <a href="{{url('playlist')}}" class='btn btn-danger'>Huy</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop