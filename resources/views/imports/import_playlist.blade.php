@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <form action="{{url('import/import_playlist')}}" method="post" role="form">
                {{csrf_field()}}
                <legend>Nhập danh sách nhạc từ Zing.mp3</legend>

                <div class="form-group">
                    <label for="">Ten playlist</label>
                    <input type="text" class="form-control" name="playlist_title" placeholder="Co the de trong">
                </div>

                <div class="form-group">
                    <label for="">URL playlist</label>
                    <input type="text" class="form-control" name="url" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Chon the loai</label>
                    <select name="cate_id" id="" class="form-control">
                        {!!$menu->make($cates,'slc',old('playlist_cate'))!!}
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lấy nào!</button>
            </form>
        </div>
    </div>
@stop