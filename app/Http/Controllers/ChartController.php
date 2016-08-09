<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Song;
use App\Chart;
use App\Playlist;
use App\Cate;

use Carbon\Carbon;

;
use Cache;

class ChartController extends Controller
{
    public function index()
    {
        return redirect()->route('home');
    }

    public function show($cate, $week_or_month = 'tuan', $index = '')
    {
        switch ($week_or_month):

            case 'tuan': // Default for week and otherwise
                $index = $index == '' ? Carbon::now()->subWeek(1)->weekOfYear : $index;
                $index = $index < 1 ? 1 : $index;
                $time_mode = Chart::TIME_WEEK;
                $start_date = Carbon::createFromFormat('z', $index * 7)->startOfWeek()->format('d/m');
                $end_date = Carbon::createFromFormat('z', $index * 7)->endOfWeek()->format('d/m');
                $max_interval = $index;
                $time_unit = 'TUẦN';
                break;

            case 'thang': // Month
                $index = $index == '' ? Carbon::now()->subMonth(1)->month : $index;
                $index = $index < 1 ? 1 : $index;
                $time_mode = Chart::TIME_MONTH;
                $start_date = Carbon::createFromFormat('m', $index)->startOfMonth()->format('d/m');
                $end_date = Carbon::createFromFormat('m', $index)->endOfMonth()->format('d/m');
                $max_interval = $index;
                $time_unit = 'THÁNG';
                break;

        endswitch;

        $song_records_cache_name = "${cate}-${week_or_month}-${index}";
        $song_records = Cache::tags(['chart', 'song'])->get($song_records_cache_name,
            function () use ($time_mode, $cate, $index, $song_records_cache_name) {
                $song_records = Chart::get_song_records($time_mode, $cate, $index, 30);
                Cache::tags(['chart', 'song'])->put($song_records_cache_name, $song_records, 86400);
                return $song_records;
            });

        $playlist_records_cache_name = "${cate}-${week_or_month}-${index}";
        $playlist_records = Cache::tags(['chart', 'playlist'])->get($playlist_records_cache_name,
            function () use ($time_mode, $cate, $index, $playlist_records_cache_name) {
                $playlist_records = Chart::get_playlist_records($time_mode, $cate, $index, 10);
                Cache::tags(['chart', 'playlist'])->put($playlist_records_cache_name, $playlist_records, 86400);
                return $playlist_records;
            });

        return view('charts.show', [
            'title' => 'Bảng xếp hạng ' . $cate->cate_title,
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
