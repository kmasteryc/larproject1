<?php

namespace App\Listeners;

use App\Events\EventPlaylistChange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Cache;
class UpdatePlaylistCache
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
     * @param  EventPlaylistChange  $event
     * @return void
     */
    public function handle(EventPlaylistChange $event)
    {
        $chart_playlists = \App\Chart::get_playlist_records(\App\Chart::TIME_WEEK, \App\Cate::where('cate_title_slug', 'viet-nam')->first(), 30, 8);
        Cache::put('chart_playlists', $chart_playlists, 86400);
    }
}
