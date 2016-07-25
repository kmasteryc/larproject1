@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sach nghe si</h3>
            </div>
            <div class="panel-body">

                {{--Bang: nghe si--}}
                <div lass="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hanh dong</th>
                            <th>Nghe danh</th>
                            <th>Ten that</th>
                            <th>Ngay sinh</th>
                            <th>Gioi tinh</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($artists as $artist)
                            <tr>
                                <td>{{$artist->id}}</td>
                                <td><a href="{{url("artist/$artist->id/edit")}}">Edit</a> - <a
                                            href="{{url("artist/$artist->id/delete")}}">Delete</a></td>
                                <td>{{$artist->artist_title}}</td>
                                <td>{{$artist->artist_name}}</td>
                                <td>{{$artist->artist_birthday}}</td>
                                <td>{{$artist->artist_gender}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--/ Bang: nghe si--}}
                    <div class="center-block">
                        <a href="{{url('artist/create')}}">
                            <button class="btn btn-success">
                                Them nghe si moi
                            </button>
                        </a>
                    </div>

            </div>
        </div>
    </div>
@stop

