@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách chủ đề </h3>
            </div>
            <div class="panel-body">

                {{--Bang: the loai nhac--}}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hành động</th>
                            <th>Tên chủ đề</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!!$menu->make($cates, 'td')!!}
                        </tbody>
                    </table>
                </div>
                {{--/ Bang: the loai nhac--}}

                {{--Form: tao the loai nhac moi--}}
                <form action="{{url('cate/store')}}" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}
                    <legend>Tạo chủ đề  mới</legend>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Chủ đề  cha</label>
                        <div class="col-sm-10">
                            <select name="cate_parent" id="" class="form-control">
                                <option value="0">Thư mục gốc</option>
                                {!! $menu->make($cates, 'slc') !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên chủ đề </label>
                        <div class="col-sm-10">
                            <input type="text" name="cate_title" class="form-control" value="{{old('cate_title')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tạo bảng xếp hạng cho chủ đề  này?</label>
                        <div class="col-sm-10">
                            <select name="cate_chart" class="form-control">
                                <option value="0">Không</option>
                                <option value="1">Có</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-info" type="submit">
                                Tạo chủ đề
                            </button>
                        </div>
                    </div>
                </form>
                {{--/Form: tao the loai nhac moi--}}
            </div>
        </div>
    </div>
@stop
