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
                            <th>Ten bai hat</th>
                            <th>Nghe si</th>
                            <th>The loai</th>
                            <th>Luot nghe</th>
                            <th>MP3</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($songs as $song)
                            <tr>
                                <td>{{$song->id}}</td>
                                <td><a href="{{url("song/$song->id/edit")}}">Edit</a> - <a
                                            href="{{url("song/$song->id/delete")}}">Delete</a></td>
                                <td>{{$song->song_title}}</td>
                                <td>
                                    @foreach($song->artists as $artist)
                                        <a href="{{url("artist/$artist->id/edit")}}" class="badge">{{$artist->artist_title}}</a>
                                    @endforeach
                                </td>
                                <td>{{$song->cate->cate_title}}</td>
                                <td>{{$song->song_view}}</td>
                                <td><a href="{{url("bai-hat/$song->song_title_slug.html")}}" target="_blank">Play</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--/ Bang: nghe si--}}
                <div class="center-block">
                    <a href="{{url('song/create')}}">
                        <button class="btn btn-success">
                            Them bai hat moi
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
@stop

