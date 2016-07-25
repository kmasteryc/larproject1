@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sua nghe si {{$artist->artist_title}}</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('artist/'.$artist->id)}}" method="POST" class="form-horizontal" role="form">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten nghe si</label>

                        <div class="col-sm-10">
                            <input type="text" name="artist_name" class="form-control" value="{{$artist->artist_name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nghe danh</label>

                        <div class="col-sm-10">
                            <input type="text" name="artist_title" class="form-control"
                                   value="{{$artist->artist_title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nam sinh</label>

                        <div class="col-sm-10">
                            <input type="date" name="artist_birthday" class="form-control"
                                   value="{{$artist->artist_birthday}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Thong tin</label>

                        <div class="col-sm-10">
                            <textarea name="artist_info" class="form-control">{{$artist->artist_info}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Gioi tinh</label>

                        <div class="col-sm-10">
                            <?php
                            $select1 = $artist->artist_gender == "Nam" ? "selected" : "";
                            $select2 = $artist->artist_gender == "Nu" ? "selected" : "";
                            ?>
                            <select class="form-control" name="artist_gender">
                                <option value="1" {{$select1}}>Nam</option>
                                <option value="0" {{$select2}}>Nu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Quoc gia</label>

                        <div class="col-sm-10">
                            <select class="form-control" name="artist_nation" id="">
                                <option value="84">Viet Nam</option>
                                <option value="8">USA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                Sua nghe si
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Cac bai hat cua {{$artist->artist_title}}
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>Hanh dong</th>
                            <th>Ten bai hat</th>
                            <th>Ngay dang</th>
                            <th>Luot nghe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($artist->songs as $song)
                            <tr>
                                <td>
                                    <a href="{{url("song/$song->id/edit")}}">Edit</a>
                                    - <a href="{{url("song/$song->id/delete")}}">Delete</a>
                                </td>
                                <td>{{$song->song_title}}</td>
                                <td>{{$song->created_at}}</td>
                                <td>{{$song->song_view}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop