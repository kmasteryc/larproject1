@inject('menu','Tools\Menu')
@extends('layouts.app')
@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Chinh sua sach nhac {{$playlist->playlist_title}}</h3>
            </div>
            <div class="panel-body">
                <form action="{{url("playlist/$playlist->id")}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ten danh sach</label>

                        <div class="col-sm-10">
                            <input type="text" name="playlist_title" class="form-control" value="{{$playlist->playlist_title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">The loai</label>

                        <div class="col-sm-10">
                            <select name="cate_id" id="" class="form-control">
                                {!!$menu->make($cates,'slc',$playlist->cate_id)!!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tim bai hat</label>

                        <div class="col-sm-10 relative">
                            <input type="text" class="form-control" id="input_songs">
                            <div class="popup search_song"></div>
                        </div>
                    </div>

                    <div class="form-group" id="div_box_song">
                        <label class="col-sm-2 control-label">Bai hat</label>
                        <input type="hidden" name="playlist_songs" id="playlist_songs" value="{{$playlist->playlist_songs_id}}">
                        <div class="col-sm-10 relative">
                            <div class="" id="div_songs">
                                <?php $i = 1;?>
                                @foreach($playlist->songs as $song)
                                    <a href="#" class="list-group-item list-group-item-info a_remove_song" data-id="{{$song->id}}">
                                        <span class='pull-left series'>{{$i}}. </span>
                                        {{$song->song_title}}
                                        <span class='pull-right'>{{$song->song_artists_title}}</span>
                                    </a>
                                    <?php $i++; ?>
                                    @endforeach
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Sua sach nhac</button>
                            <a href="{{url('playlist')}}" class='btn btn-danger'>Huy</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop