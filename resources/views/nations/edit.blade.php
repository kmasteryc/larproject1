@extends('layouts.app')

@section('content')

    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sửa quốc gia </h3>
            </div>
            <div class="panel-body">

                <form action="{{url("nation/$nation->id")}}" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('PUT') !!}

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên quốc gia</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nation_title" value="{!! $nation->nation_title !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Mã quốc gia</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id" value="{!! $nation->id !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-info" type="submit">
                                Sửa quốc gia
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection