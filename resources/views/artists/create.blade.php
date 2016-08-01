@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Them nghe si moi</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('artist/store')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten nghe si</label>
                        <div class="col-sm-10">
                            <input type="text" name="artist_name" class="form-control" value="{{old('artist_name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nghe danh</label>
                        <div class="col-sm-10">
                            <input type="text" name="artist_title" class="form-control"
                                   value="{{old('artist_title')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nam sinh</label>
                        <div class="col-sm-10">
                            <input type="date" name="artist_birthday" class="form-control"
                                   value="{{old('artist_birthday')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Anh dai dien</label>
                        <div class="col-sm-10">
                            <input type="file" name="artist_img_small" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Anh cover</label>
                        <div class="col-sm-10">
                            <input type="file" name="artist_img_cover" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Thong tin</label>
                        <div class="col-sm-10">
                            <textarea name="artist_info" class="form-control">{{old('artist_info')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gioi tinh</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="artist_gender">
                                <option value="1">Nam</option>
                                <option value="0">Nu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Quoc gia</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="artist_nation" id="">
                                <option value="84">Viet Nam</option>
                                <option value="8">USA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                Them nghe si
                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@stop