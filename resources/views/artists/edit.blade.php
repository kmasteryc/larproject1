@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sửa nghệ sĩ {!!$artist->artist_title!!}</h3>
            </div>
            <div class="panel-body">
                <form action="{!!url('artist/'.$artist->id)!!}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                    {!!method_field('PUT')!!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tên nghệ sĩ</label>

                        <div class="col-sm-10">
                            <input type="text" name="artist_name" class="form-control" value="{!!$artist->artist_name!!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nghệ danh</label>

                        <div class="col-sm-10">
                            <input type="text" name="artist_title" class="form-control"
                                   value="{!!$artist->artist_title!!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Năm sinh</label>

                        <div class="col-sm-10">
                            <input type="date" name="artist_birthday" class="form-control"
                                   value="{!!$artist->artist_birthday_html!!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Ảnh đại diện
                        </label>
                        <div class="col-sm-10">
                            <img src="{!! $artist->artist_img_small !!}" height="100px" width="auto" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Ảnh đại diện mới
                        </label>
                        <div class="col-sm-10">
                            <input type="file" name="artist_img_small" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Ảnh cover
                        </label>
                        <div class="col-sm-10">
                            <img src="{!! $artist->artist_img_cover !!}" height="100px" width="auto" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Ảnh cover mới
                        </label>
                        <div class="col-sm-10">
                            <input type="file" name="artist_img_cover" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Thông tin</label>

                        <div class="col-sm-10">
                            <textarea name="artist_info" rows="5" class="form-control">{!!$artist->artist_info!!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Giới tính</label>

                        <div class="col-sm-10">
                            <?php
                            $select1 = $artist->artist_gender == "Nam" ? "selected" : "";
                            $select2 = $artist->artist_gender == "Nữ" ? "selected" : "";
                            ?>
                            <select class="form-control" name="artist_gender">
                                <option value="1" {!!$select1!!}>Nam</option>
                                <option value="0" {!!$select2!!}>Nữ</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Quốc gia</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="nation_id">
                                @foreach ($nations as $nation)
                                    <option
                                            value="{!! $nation->id !!}"
                                            {!! $nation->id == $artist->nation_id ? "selected" : "" !!}
                                    >
                                        {!! $nation->nation_title !!}
                                    </option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                Sửa nghệ sĩ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                Album của nghệ sĩ {!!$artist->artist_title!!}
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>Hành động</th>
                            <th>Tên album</th>
                            <th>Ngày đăng</th>
                            <th>Lượt nghe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($artist->playlists as $playlist)
                            <tr>
                                <td>
                                    <a href="{!!url("playlist/$playlist->id/edit")!!}">Sửa</a>
                                    - <a href="{!!url("playlist/$playlist->id/delete")!!}">Xóa</a>
                                </td>
                                <td>{!!$playlist->playlist_title!!}</td>
                                <td>{!!$playlist->created_at!!}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                Các bài hát nghệ sĩ {!!$artist->artist_title!!} thể hiện
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>Hành động</th>
                            <th>Tên bài hát</th>
                            <th>Ngày đăng</th>
                            <th>Lượt nghe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($artist->songs as $song)
                            <tr>
                                <td>
                                    <a href="{!!url("song/$song->id/edit")!!}">Sửa</a>
                                    - <a href="{!!url("song/$song->id/delete")!!}">Xóa</a>
                                </td>
                                <td>{!!$song->song_title!!}</td>
                                <td>{!!$song->created_at!!}</td>
                                <td>{!!$song->song_view!!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@stop
