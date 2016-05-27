@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-8 col-md-offset-2">
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
                                <td><a href="{{url("playlist/$playlist->id/edit")}}">Edit</a> - <a
                                            href="{{url("playlist/$playlist->id/delete")}}">Delete</a></td>
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
                            Them danh sach nhac moi
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
@stop

