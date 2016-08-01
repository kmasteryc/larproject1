@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4>
                                BẢNG XẾP HẠNG {!! $cate->cate_title !!} {!! $timeinfo['time_unit'] !!} {!! $timeinfo['index'] !!}
                                ({!! $timeinfo['start_date'] !!} - {!! $timeinfo['end_date'] !!})
                            </h4>
                        </div>
                        <div class="pull-right">
                            <h4>
                                <select id="index_choose" class="form-control" name="index"
                                        data-cate-title-slug='{!! $cate->cate_title_slug !!}'
                                        data-unit-slug='{!! strtolower(str_slug($timeinfo['time_unit']))!!}'>
                                    <?php
                                    for ($i = 1; $i <= $timeinfo['max_interval']; $i++):
                                        $opt = $i == $timeinfo['index'] ? 'selected' : '';
                                        echo "<option $opt value='$i'>";
                                        echo "$timeinfo[time_unit] $i";
                                        echo "</option>";
                                    endfor;
                                    ?>
                                </select>

                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    Bảng xếp hạng được tạo tự động dựa trên số lượng lượt nghe trong từng khoảng thời gian.
                </div>
                <div class="row">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#bai-hat" role="tab"
                                                                      data-toggle="tab">Bài hát</a></li>
                            <li role="presentation"><a href="#album" role="tab"
                                                       data-toggle="tab">Album</a></li>
                            <li role="presentation" class="pull-right" id="playall-link">
                                <a href="{!! url("bang-xep-hang/".$cate->cate_title_slug."/".str_slug($timeinfo['time_unit'])."-$timeinfo[index]/play.html") !!}">
                                    <i class="fa fa-play-circle-o"></i>
                                    Nghe tất cả
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="bai-hat">
                                @include('charts.partials.chart_song',['songs'=>$song_records])
                            </div>

                            <div role="tabpanel" class="tab-pane" id="album">
                                @include('charts.partials.chart_album',['albums'=>$playlist_records])
                            </div>


                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
                {{--@todo: Side chart module--}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('global_partials/modal_add_to_playlist')
@endsection