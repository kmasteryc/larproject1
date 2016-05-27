@inject('menu', 'Tools\Menu')

@extends('layouts.app')
@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sach the loai nhac</h3>
            </div>
            <div class="panel-body">

                {{--Bang: the loai nhac--}}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hanh dong</th>
                            <th>Ten</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!!$menu->make($cates, 'td')!!}
                        </tbody>
                    </table>
                </div>
                {{--/ Bang: the loai nhac--}}

                {{--Form: tao the loai nhac moi--}}
                <form action="{{url('cate/store')}}" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}
                    <legend>Tao chu de moi</legend>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Chu de cha</label>
                        <div class="col-sm-10">
                            <select name="cate_parent" id="" class="form-control">
                                <option value="0">ROOT</option>
                                {!! $menu->make($cates, 'slc') !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten chu de</label>
                        <div class="col-sm-10">
                            <input type="text" name="cate_title" class="form-control" value="{{old('cate_title')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-info" type="submit">
                                Tao chu de
                            </button>
                        </div>
                    </div>
                </form>
                {{--/Form: tao the loai nhac moi--}}
            </div>
        </div>
    </div>
@stop