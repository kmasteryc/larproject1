<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Playlist extends Model
{
    protected $fillable = ['playlist_title', 'playlist_view', 'user_id', 'cate_id'];
    protected $appends = ['total_songs'];

//	protected $appends = ['playlist_songs_id','playlist_songs_title'];

    public function cate()
    {
        return $this->belongsTo(Cate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function getPlaylistSongsIdAttribute()
    {
        $playlist_songs = $this->songs;
//		dd($playlist_songs);
        $str_playlist_songs = '';
        foreach ($playlist_songs as $playlist_song) {
            $str_playlist_songs .= $playlist_song->id . ',';
        }
        return $str_playlist_songs;
    }


    public function getTotalSongsAttribute()
    {
        return $this->songs()->count();
    }

    public function delTrash()
    {
        $pls = Playlist::all();

        $count = 0;
        foreach ($pls as $pl) {
            if (count($pl->songs) == 0) {
                $pl->delete();
                $count++;
            }
        }
        return $count;
    }

    static function getUserPlaylist($include_guest)
    {
        $playlists = Cache::get('user_playlists['.request()->getClientIp().']', function() use ($include_guest){
            $playlists = [];
            $user_playlists = [];

            // Get temp playlist in session
            $temp_playlist = session()->get('temp_playlist');

            // If not exists create it
            if (!$temp_playlist) {
                $temp_playlist = [
                    'id' => 0,
                    'playlist_title' => 'Danh sách tạm thời',
//                'total_songs' => 0,
                    'playlist_songs_id' => ''
                ];
                session()->put('temp_playlist', $temp_playlist);
            }
            $temp_playlist['playlist_title_slug'] = 'danh-sach-tam';

            if ($include_guest === true) {
                // Assign temp to all playlist
                $playlists[] = $temp_playlist;
            }

            // If have user playlist. Assign it
            if (auth()->user()) {

                // Awesome Eager loading!
                $user_playlists = Playlist::where('user_id', auth()->user()->id)
                    ->select('playlist_title', 'playlists.id','playlist_title_slug')
                    ->with('songs')
                    ->get();

                foreach ($user_playlists as $user_playlist) {
                    // Foreach to assign each song id to songs_id
                    $songs_id = '';
                    foreach ($user_playlist->songs as $song) {
                        $songs_id .= $song->id . ',';
                    }
                    $hehe = [
                        'id' => $user_playlist->id,
                        'playlist_title' => $user_playlist->playlist_title,
                        'playlist_title_slug' => $user_playlist->playlist_title_slug,
//                    'total_songs' => $user_playlist->total_songs,
                        'playlist_songs_id' => $songs_id
                    ];
                    $playlists[] = $hehe;
                }
            }
            return $playlists;
        });

        Cache::put('user_playlists['.request()->getClientIp().']', $playlists, 1000000);
        return $playlists;
    }
}
