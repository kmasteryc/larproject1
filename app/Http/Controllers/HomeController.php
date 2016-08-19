<?php

namespace App\Http\Controllers;

use App\Cate;
use App\Http\Requests;
use App\Song;
use App\Chart;
use App\Playlist;
use Cache;
use Tools\Khelper;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $new_songs = Cache::store('file')->get('new_songs', function () {
            $new_songs = Song::inRandomOrder()->take(3)->with('artists')->get();
//            Cache::store('file')->put('new_songs', $new_songs, 86400);
//            return $new_songs;
//        });
//        $chart_songs = Cache::store('file')->get('chart_songs', function () {
            $chart_songs = Chart::get_song_records(Chart::TIME_WEEK, Cate::where('cate_chart', '1')->first(), 30, 10);
//            Cache::store('file')->put('chart_songs', $chart_songs, 86400);
//            return $chart_songs;
//        });
//        $chart_playlists = Cache::store('file')->get('chart_playlists', function () {
//            $chart_playlists = Chart::get_playlist_records(Chart::TIME_WEEK, Cate::where('cate_title_slug', 'viet-nam')->first(), 30, 8);
	    $chart_playlists = Playlist::orderBy('created_at', 'DESC')->take(8)->get();
//            Cache::store('file')->put('chart_playlists', $chart_playlists, 86400);
//            return $chart_playlists;
//        });

        $data['chart_songs'] = $chart_songs;
        $data['chart_playlists'] = $chart_playlists;
        $data['new_songs'] = $new_songs;
        return view('home.index', $data);
    }
}
