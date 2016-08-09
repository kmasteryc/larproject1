<?php

namespace App\Http\Controllers;

use App\Playlist;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\View;
use App\Song;

class MashController extends Controller
{
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
            $view = View::firstOrNew([
                'viewable_type'=>Song::class,
                'viewable_id'=>$song->id,
                'view_date'=>date('Y-m-d'),
            ]);
            $view->view_count++;
            $view->save();
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
            $view = View::firstOrNew([
                'viewable_type'=>Playlist::class,
                'viewable_id'=>$playlist->id,
                'view_date'=>date('Y-m-d'),
            ]);
            $view->view_count++;
            $view->save();
        }
    }

}
