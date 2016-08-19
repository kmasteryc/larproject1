<?php

namespace App\Listeners;

use App\Events\EventSongChange;
use Cache;

class UpdateSongCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventSongChange  $event
     * @return void
     */
    public function handle(EventSongChange $event)
    {
//        $new_songs = \App\Song::orderBy('created_at', 'DESC')->take(3)->with('artists')->get();
//        Cache::put('new_songs', $new_songs, 86400);
//
//        $chart_songs = \App\Chart::get_song_records(\App\Chart::TIME_WEEK, \App\Cate::where('cate_title_slug', 'viet-nam')->first(), 30, 10);
//        Cache::put('chart_songs', $chart_songs, 86400);
    }
}
