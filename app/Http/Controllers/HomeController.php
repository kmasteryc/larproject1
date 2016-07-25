<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Song;

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
        $new_songs = Song::orderBy('created_at','DESC')->take(3)->with('artists')->get();
//        dd($new_songs);
        $data['new_songs'] = $new_songs;
        $data['myjs'] = ['pslider.js','home/index.js'];
        $data['mycss'] = ['pslider.css'];
        return view('home.index',$data);
    }
}
