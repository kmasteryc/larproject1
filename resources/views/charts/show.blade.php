@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="media">
                            <div class="media-body">
                                <h4>
                                    BẢNG XẾP
                                    HẠNG {!! $cate->cate_title !!} {!! $timeinfo['time_unit'] !!} {!! $timeinfo['index'] !!}
                                    ({!! $timeinfo['start_date'] !!} - {!! $timeinfo['end_date'] !!})
                                </h4>
                            </div>
                            <div class="media-right media-middle">
                                    <select id="index_choose" class="btn" name="index"
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        Bảng xếp hạng được tạo tự động dựa trên số lượng lượt nghe trong từng khoảng thời gian.
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#bai-hat" role="tab"
                                                                      data-toggle="tab">Bài hát</a></li>
                            <li role="presentation"><a href="#album" role="tab"
                                                       data-toggle="tab">Album</a></li>
                            <li role="presentation" class="pull-right" id="playall-link">
                                <a href="{!! url("bang-xep-hang/".$cate->cate_title_slug."/".str_slug($timeinfo['time_unit'])."-$timeinfo[index]/play.html") !!}">
                                    <i class="fa fa-play-circle-o"></i>
                                    Nghe
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
        </div>
    </div>

    <!-- Modal -->
    @include('global_partials/modal_add_to_playlist')
@endsection