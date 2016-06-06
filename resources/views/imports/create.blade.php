@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <form action="{{url('import')}}" method="post" role="form">
                {{csrf_field()}}
                <legend>Nhập danh sách nhạc từ Zing.mp3</legend>

                <div class="form-group">
                    <label for=""></label>
                    <input type="text" class="form-control" name="url" id="" placeholder="URL album">
                </div>
                <button type="submit" class="btn btn-primary">Lấy nào!</button>
            </form>
        </div>
    </div>
@stop