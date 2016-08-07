@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Edit user</h3>
            </div>
            <div class="panel-body">


                <form class="form-horizontal" action="{!! url("user/$user->id") !!}" method="POST" role="form">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="text" name="email" class="form-control" value="{!! $user->email !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Level</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="level">
                                <option value="1" <?= $user->level == 1 ? 'selected' : '' ?>>Member</option>
                                <option value="2" <?= $user->level == 2 ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách nhạc của {!! $user->name !!}</h3>
            </div>
            <div class="panel-body">
                <div style="text-align: center">
                    {!! $playlists->links() !!}
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
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
                        @foreach($playlists as $playlist)
                            <tr>
                                <td>{{$playlist->id}}</td>
                                <td><a href="{{url("playlist/$playlist->id/edit")}}">Sửa</a> - <a
                                            href="{{url("playlist/$playlist->id/delete")}}">Xóa</a></td>
                                <td>
                                    <a href="{{url("playlist/$playlist->playlist_title_slug")}}">
                                        {{$playlist->playlist_title}}
                                    </a>
                                </td>
                                <td>{{$playlist->songs_count}}</td>
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
