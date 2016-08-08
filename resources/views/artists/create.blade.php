@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Thêm nghệ sĩ</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('artist/store')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên nghệ sĩ</label>
                        <div class="col-sm-10">
                            <input type="text" name="artist_name" class="form-control" value="{{old('artist_name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nghệ danh</label>
                        <div class="col-sm-10">
                            <input type="text" name="artist_title" class="form-control"
                                   value="{{old('artist_title')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Năm sinh</label>
                        <div class="col-sm-10">
                            <input type="date" name="artist_birthday" class="form-control"
                                   value="{{old('artist_birthday')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ảnh đại diện</label>
                        <div class="col-sm-10">
                            <input type="file" name="artist_img_small" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ảnh cover</label>
                        <div class="col-sm-10">
                            <input type="file" name="artist_img_cover" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Thông tin</label>
                        <div class="col-sm-10">
                            <textarea name="artist_info" class="form-control">{{old('artist_info')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Giới tính</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="artist_gender">
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Quốc gia</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="nation_id">
                                @foreach ($nations as $nation)
                                    <option value="{!! $nation->id !!}">
                                        {!! $nation->nation_title !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                Thêm nghệ sĩ
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop
