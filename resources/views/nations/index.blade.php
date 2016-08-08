@extends('layouts.app')

@section('content')

    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách quốc gia </h3>
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Mã quốc gia</th>
                            <th>Hành động</th>
                            <th>Tên quốc gia</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($nations as $nation)
                            <tr>
                                <td>{!! $nation->id !!}</td>
                                <td>
                                    <a href="{!! url("nation/$nation->id/edit") !!}">Sửa</a> -
                                    <a href="{!! url("nation/$nation->id/delete") !!}">Xóa</a>
                                </td>
                                <td>{!! $nation->nation_title !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <form action="{{url('nation')}}" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên quốc gia</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nation_title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Mã quốc gia</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-info" type="submit">
                                Tạo quốc gia
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection