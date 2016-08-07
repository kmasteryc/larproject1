@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                Sửa chủ đề {{$cate->cate_title}}
            </div>
            <div class="panel-body">
                <form action="{{url("cate/$cate->id")}}" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Chủ đề  cha</label>
                        <div class="col-sm-9">
                            <select name="cate_parent" id="" class="form-control">
                                <option value="0">ROOT</option>
                                {!! $menu->make($cates, 'slc', $cate->cate_parent) !!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên chủ đề </label>
                        <div class="col-sm-9">
                            <input type="text" name="cate_title" class="form-control" value="{{$cate->cate_title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tạo bảng xếp hạng cho chủ đề  này?</label>
                        <div class="col-sm-9">
                            <select name="cate_chart" class="form-control">
                                <option value="0" {!! $sl= $cate->cate_chart == 0 ? 'selected' : '' !!}>Không</option>
                                <option value="1" {!! $sl= $cate->cate_chart == 1 ? 'selected' : '' !!}>Có</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                            <a class="btn btn-danger" href="{{url('cate')}}">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-primary">
        	  <div class="panel-heading">
        			<h3 class="panel-title">Danh sách album thuộc chủ đề {{$cate->cate_title}}</h3>
        	  </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hành động</th>
                            <th>Tên album</th>
                            <th>Số bài hát</th>
                            <th>Lượt nghe</th>
                            <th>Cập nhật cuối</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cate->playlists as $playlist)
                            <tr>
                                <td>{{$playlist->id}}</td>
                                <td><a href="{{url("playlist/$playlist->id/edit")}}">Sửa</a> - <a
                                            href="{{url("playlist/$playlist->id/delete")}}">Xóa</a></td>
                                <td>
                                    <a href="{{url("playlist/$playlist->playlist_title_slug")}}">
                                        {{$playlist->playlist_title}}
                                    </a>
                                </td>
                                <td>{{count($playlist->songs)}}</td>
                                <td>{{$playlist->playlist_view}}</td>
                                <td>{{$playlist->updated_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@stop
