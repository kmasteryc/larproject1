<?php

namespace App\Http\Controllers;

use App\Cate;
use App\Http\Requests;
use App\Song;
use App\Chart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::with('cate')->get();

        $new_songs = Song::orderBy('created_at','DESC')->take(3)->with('artists')->get();
        $chart_songs = Chart::get_song_records(Chart::TIME_WEEK,Cate::where('cate_title_slug','viet-nam')->first(),30,10);
        $chart_playlists = Chart::get_playlist_records(Chart::TIME_WEEK,Cate::where('cate_title_slug','viet-nam')->first(),30,8);

        $data['chart_songs'] = $chart_songs;
        $data['chart_playlists'] = $chart_playlists;
        $data['new_songs'] = $new_songs;
        $data['myjs'] = ['pslider.js','home/index.js'];
        $data['mycss'] = ['pslider.css'];
        return view('home.index',$data);
    }
}
