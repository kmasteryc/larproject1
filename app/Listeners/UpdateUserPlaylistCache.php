<?php

namespace App\Listeners;

use App\Events\EventUserPlaylistChange;
use Cache;
use App\Playlist;

class UpdateUserPlaylistCache
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
     * @param  EventUserPlaylistChange  $event
     * @return void
     */
    public function handle(EventUserPlaylistChange $event)
    {
        Cache::forget('user_playlists['.request()->getClientIp().']');
        Playlist::getUserPlaylist(true);
    }
}
