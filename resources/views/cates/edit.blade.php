@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                Chinh sua chu de {{$cate->cate_title}}
            </div>
            <div class="panel-body">
                <form action="{{url("cate/$cate->id")}}" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Chu de cha</label>
                        <div class="col-sm-10">
                            <select name="cate_parent" id="" class="form-control">
                                <option value="0">ROOT</option>
                                {!! $menu->make($cates, 'slc', $cate->cate_parent) !!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten chu de</label>
                        <div class="col-sm-10">
                            <input type="text" name="cate_title" class="form-control" value="{{$cate->cate_title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-info" type="submit">Cap nhat</button>
                            <a class="btn btn-danger" href="{{url('cate')}}">Huy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-primary">
        	  <div class="panel-heading">
        			<h3 class="panel-title">Danh sach nhac thuoc {{$cate->cate_title}}</h3>
        	  </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hanh dong</th>
                            <th>Ten danh sach bai hat</th>
                            <th>So bai hat</th>
                            <th>Luot nghe</th>
                            <th>Cap nhat cuoi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cate->playlists as $playlist)
                            <tr>
                                <td>{{$playlist->id}}</td>
                                <td><a href="{{url("playlist/$playlist->id/edit")}}">Edit</a> - <a
                                            href="{{url("playlist/$playlist->id/delete")}}">Delete</a></td>
                                <td>{{$playlist->playlist_title}}</td>
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