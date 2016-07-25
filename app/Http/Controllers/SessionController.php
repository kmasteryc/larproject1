<?php

namespace App\Http\Controllers;

use App\Playlist;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Song;

class SessionController extends Controller
{
    public function index()
    {
        echo 'Session controller!';
    }
    public function set(Request $request, $k, $v)
    {
        $request->session()->put($k,$v);
        echo "Set $k to ".$request->session()->get($k);
    }
    function addSongPlaylist($song_id,$song)
    {
        $temp_playlist = session()->get('temp_playlist');
    }

    static function increase_view_song(Song $song){

        // Get time view records from session
        $cur_ses = request()->session()->get('last_time_song');

        // If record for cur song not exits or duration between difference playing > 120s -> update record
        if (!isset($cur_ses[$song->id]) || (time() - $cur_ses[$song->id]) > 1) {
            // Set record time
            $cur_ses[$song->id] = time();

            // Update to session
            request()->session()->put('last_time_song', $cur_ses);

            // Update to database
            $song->song_view++;
            $song->save();
        }
    }
    static function increase_view_playlist(Playlist $playlist){

        // Get time view records from session
        $cur_ses = request()->session()->get('last_time_playlist');

        // If record for cur song not exits or duration between difference playing > 120s -> update record
        if (!isset($cur_ses[$playlist->id]) || (time() - $cur_ses[$playlist->id]) > 1) {
            // Set record time
            $cur_ses[$playlist->id] = time();

            // Update to session
            request()->session()->put('last_time_playlist', $cur_ses);

            // Update to database
            $playlist->playlist_view++;
            $playlist->save();
        }
    }

}
