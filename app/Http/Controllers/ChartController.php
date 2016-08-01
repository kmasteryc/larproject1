<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Song;
use App\Chart;
use App\Playlist;
use App\Cate;

use Carbon\Carbon;

class ChartController extends Controller
{
    public function index()
    {
        return view('charts.index', [
            'cp' => true
        ]);
    }

    public function show($cate, $week_or_month = 'tuan', $index = '')
    {
//        $cate = Cate::fromSlug($cate_title_slug);

        switch ($week_or_month):

            case 'tuan': // Default for week and otherwise
                $index = $index == '' ? Carbon::now()->subWeek(1)->weekOfYear : $index;
                $index = $index < 1 ? 1 : $index;
                $time_mode = Chart::TIME_WEEK;
                $start_date = Carbon::createFromFormat('z', $index * 7)->startOfWeek()->format('d/m');
                $end_date = Carbon::createFromFormat('z', $index * 7)->endOfWeek()->format('d/m');
                $max_interval = 52;
                $time_unit = 'TUẦN';
                break;

            case 'thang': // Month
                $index = $index == '' ? Carbon::now()->subMonth(1)->month : $index;
                $index = $index < 1 ? 1 : $index;
                $time_mode = Chart::TIME_MONTH;
                $start_date = Carbon::createFromFormat('m', $index)->startOfMonth()->format('d/m');
                $end_date = Carbon::createFromFormat('m', $index)->endOfMonth()->format('d/m');
                $max_interval = 12;
                $time_unit = 'THÁNG';
                break;

        endswitch;

        $song_records = Chart::get_song_records($time_mode, $cate, $index, 30);

        $playlist_records = Chart::get_playlist_records($time_mode, $cate, $index, 10);

        return view('charts.show', [
            'title' => 'Bảng xếp hạng '.$cate->cate_title,
            'myjs' => ['charts/show.js', 'playlists/show.js'],
            'timeinfo' => [
                'time_unit' => $time_unit,
                'max_interval' => $max_interval,
                'index' => $index,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ],
            'cate' => $cate,
            'song_records' => $song_records,
            'playlist_records' => $playlist_records
        ]);
    }
}
