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
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hành động</th>
                            <th>Tên đăng nhập</th>
                            <th>Email</th>
                            <th>Cập nhật cuối</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{!! $user->id !!}</td>
                                <td>
                                    <a href="{!! url("user/$user->id/edit") !!}">Sửa</a> -
                                    <a href="{!! url("user/$user->id/delete") !!}">Xóa</a>
                                </td>
                                <td>{!! $user->name !!}</td>
                                <td>{!! $user->email !!}</td>
                                <td>{!! $user->updated_at !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@stop
