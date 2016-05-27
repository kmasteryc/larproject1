@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h4>Edit category {{$cate->cate_title}}</h4>
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
@stop