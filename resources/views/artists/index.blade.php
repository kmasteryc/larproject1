@inject('menu', 'Tools\Menu')
@inject('khelper', 'Tools\Khelper')

@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách nghệ sĩ</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <input class="form-control" type="text" id="autocomplete" placeholder="Tìm kiếm">
                </div>
                {{--Bang: nghe si--}}
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hành động</th>
                            <th>Nghệ danh</th>
                            <th>Tên thật</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th class="hidden">Virtual</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($artists as $artist)
                            <tr>
                                <td>{{$artist->id}}</td>
                                <td><a href="{{url("artist/$artist->id/edit")}}">Sửa</a> - <a
                                            href="{{url("artist/$artist->id/delete")}}">Xóa</a></td>
                                <td>{{$artist->artist_title}}</td>
                                <td>{{$artist->artist_name}}</td>
                                <td>{{$artist->artist_birthday}}</td>
                                <td>{{$artist->artist_gender}}</td>
                                <td class="hidden">{!! $khelper::removeVietNamese($artist->artist_title).' '.$khelper::removeVietNamese($artist->artist_name) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--/ Bang: nghe si--}}
                    <div class="center-block">
                        <a href="{{url('artist/create')}}">
                            <button class="btn btn-success">
                                Thêm nghệ sĩ mới
                            </button>
                        </a>
                    </div>

            </div>
        </div>
    </div>
@stop
