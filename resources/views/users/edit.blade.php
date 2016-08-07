@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách người sử dụng</h3>
            </div>
            <div class="panel-body">

                {{--Bang: nghe si--}}

            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách nhạc của {!! $user->name !!}</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hành động</th>
                            <th>Tên danh sách</th>
                            <th>Số bài hát</th>
                            <th>Lượt nghe</th>
                            <th>Cập nhật cuối</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->playlists as $playlist)
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
