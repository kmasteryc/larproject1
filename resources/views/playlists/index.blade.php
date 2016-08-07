@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách bài hát</h3>
            </div>
            <div class="panel-body">

                {{--Bang: nghe si--}}
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hành động</th>
                            <th>Ảnh</th>
                            <th>Tên danh sách</th>
                            <th>Thể loại</th>
                            <th>Số bài hát</th>
                            <th>Lượt nghe</th>
                            <th>Cập nhật cuối</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($playlists as $playlist)
                            <tr>
                                <td>{{$playlist->id}}</td>
                                <td>
                                    <a href="{{url("playlist/$playlist->playlist_title_slug.html")}}">Chơi</a> -
                                    <a href="{{url("playlist/$playlist->id/edit")}}">Sửa</a> -
                                    <a href="{{url("playlist/$playlist->id/delete")}}">Xóa</a></td>
                                <td><img src="{{$playlist->playlist_img}}" alt="" height="50px" width="50px"></td>
                                <td>{{$playlist->playlist_title}}</td>
                                <td><a href="{{url("cate/".$playlist->cate->id."/edit")}}">{{$playlist->cate->cate_title}}</a></td>
                                <td>{{count($playlist->songs)}}</td>
                                <td>{{$playlist->playlist_view}}</td>
                                <td>{{$playlist->updated_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--/ Bang: nghe si--}}
                <div class="center-block">
                    <a href="{{url('playlist/create')}}">
                        <button class="btn btn-success">
                            Tạo danh sách nhạc mới
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
@stop
