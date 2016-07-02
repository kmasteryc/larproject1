@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sach bai hat</h3>
            </div>
            <div class="panel-body">

                {{--Bang: nghe si--}}
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hanh dong</th>
                            <th>Anh</th>
                            <th>Ten danh sach bai hat</th>
                            <th>The loai</th>
                            <th>So bai hat</th>
                            <th>Luot nghe</th>
                            <th>Cap nhat cuoi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($playlists as $playlist)
                            <tr>
                                <td>{{$playlist->id}}</td>
                                <td><a href="{{url("user/playlist/$playlist->id/edit")}}">Edit</a> - <a
                                            href="{{url("user/playlist/$playlist->id/delete")}}">Delete</a></td>
                                <td><img src="{{$playlist->image['image_path']}}" alt="" height="50px" width="50px"></td>
                                <td>{{$playlist->playlist_title}}</td>
                                <td>{{$playlist->cate->cate_title}}</td>
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
                            Them danh sach nhac moi
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
@stop

