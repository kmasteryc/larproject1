@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Sửa danh sách nhạc: {{$playlist->playlist_title}}</h3>
            </div>
            <div class="panel-body">
                <form action="{{url("playlist/$playlist->id")}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên danh sách</label>

                        <div class="col-sm-9">
                            <input type="text" name="playlist_title" class="form-control" value="{{$playlist->playlist_title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thể loại</label>

                        <div class="col-sm-9">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc',$playlist->cate_id)!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nghệ sĩ thể hiện</label>

                        <div class="col-sm-9">
                            <select name="artist_id" id="" class="form-control">
                                @foreach ($artists as $artist)
                                    <option value="{!! $artist->id !!}" {!! $artist->id == $playlist->artist_id ? 'selected' : '' !!}>
                                        {!! $artist->artist_title !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vài dòng giới thiệu</label>

                        <div class="col-sm-9">
                            <input type="text" name="playlist_info" class="form-control" value="{{$playlist->playlist_info}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ảnh cũ</label>

                        <div class="col-sm-9">
                            <img src="{{$playlist->playlist_img}}" alt="" height="50px" width="50px">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Upload ảnh mới </label>

                        <div class="col-sm-9">
                            <input type="file" name="playlist_img" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tìm bài hát</label>

                        <div class="col-sm-9 relative">
                            <input type="text" class="form-control" id="input_songs">
                            <div class="popup search_song"></div>
                        </div>
                    </div>

                    <div class="form-group" id="div_box_song">
                        <label class="col-sm-3 control-label">Bài hát đã chọn</label>
                        <input type="hidden" name="playlist_songs" id="playlist_songs" value="{{$playlist->playlist_songs_id}}">
                        <div class="col-sm-9 relative">
                            <div class="" id="div_songs">
                                <?php $i = 1;?>
                                @foreach($playlist->songs as $song)
                                    <a href="#" class="list-group-item list-group-item-info a_remove_song" data-id="{{$song->id}}">
                                        <span class='pull-left series'>{{$i}}. </span>
                                        {{$song->song_title}}
                                        <span class='pull-right'>{{$song->song_artists_title_text}}</span>
                                    </a>
                                    <?php $i++; ?>
                                    @endforeach
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>

                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-success">Sửa</button>
                            <a href="{{url('playlist')}}" class='btn btn-danger'>Hủy</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop