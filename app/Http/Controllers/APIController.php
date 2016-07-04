<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cate;
use App\Playlist;
use App\Song;
use App\Http\Requests;

//use Tools\Khelper;

class APIController extends Controller
{
    public function getSongsInCate(Cate $cate)
    {
        $songs = $cate->songs()->select('id', 'song_title', 'song_mp3', 'song_img')->get();
        foreach ($songs as $song) {
            $lyric_obj = $song->lyrics()->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC')->first();
            $img = $song->song_img !== '' ? $song->song_img : 'http://image.mp3.zdn.vn/cover3_artist/f/b/fb32b1dce0d8487b0916284892123f79_1459843495.jpg';
            $res[] = [
                'song_id' => $song->id,
                'song_title' => $song->song_title,
                'song_mp3' => $song->song_mp3,
                'song_artist' => $song->song_artists_title_text,
                'song_img' => $img,
                'song_lyric' => $lyric_obj['lyric_content']
            ];
        }
        return response()->json($res);
    }

    public function getSongsInPlaylist($playlist)
    {
        if ($playlist == 0) {
            $playlist = session()->get('temp_playlist');
            if (!$playlist) {
                return '';
            }
            $song_ids = explode(',', $playlist['playlist_songs_id']);
            $songs = Song::whereIn('id', $song_ids)->get();
        } else {
            $playlist = Playlist::find($playlist);
            $songs = $playlist->songs()->select('songs.id', 'song_title', 'song_mp3', 'song_img')->orderBy('song_title')->get();

        }
        foreach ($songs as $song) {
            $lyric_obj = $song->lyrics()->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC')->first();
            $img = $song->song_img !== '' ? $song->song_img : 'http://image.mp3.zdn.vn/cover3_artist/f/b/fb32b1dce0d8487b0916284892123f79_1459843495.jpg';
            $res[] = [
                'song_id' => $song->id,
                'song_title' => $song->song_title,
                'song_mp3' => $song->song_mp3,
                'song_artist' => $song->song_artists_title_text,
                'song_img' => $img,
                'song_lyric' => $lyric_obj['lyric_content']
            ];
        }
        return response()->json($res);
    }

    public function getSong(Song $song)
    {

        $lyric_obj = $song->lyrics()->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC')->first();
        $img = $song->song_img !== '' ? $song->song_img : 'http://image.mp3.zdn.vn/cover3_artist/f/b/fb32b1dce0d8487b0916284892123f79_1459843495.jpg';
        $res[] = [
            'song_id' => $song->id,
            'song_title' => $song->song_title,
            'song_mp3' => $song->song_mp3,
            'song_artist' => $song->song_artists_title_text,
            'song_img' => $img,
            'song_lyric' => $lyric_obj['lyric_content']
        ];

        return response()->json($res);
    }

    public function getUserPlaylist($include_guest = "true")
    {
        $playlists = '';
        if ($include_guest == "true") {
            $temp_playlist = session()->get('temp_playlist');
            if (!$temp_playlist) {
                $temp_playlist = [
                    'id' => 0,
                    'playlist_title' => 'Danh sách tạm thời',
                    'total_songs' => 0,
                    'playlist_songs_id' => ''
                ];
                session()->put('temp_playlist', $temp_playlist);
            }
            $playlists[0] = $temp_playlist;

            if (auth()->user()) {
                $user_playlists = Playlist::where('user_id', auth()->user()->id)->select('playlist_title', 'playlists.id')->get()->toArray();
                $playlists = array_merge($playlists, $user_playlists);
            }
        } else {
            if (auth()->user()) {
                $playlists = Playlist::where('user_id', auth()->user()->id)->select('playlist_title', 'playlists.id')->get()->toArray();
            }
        }

        return response()->json($playlists);
    }

    public function addSongToPlaylist()
    {
        $data = json_decode(request()->get('data'));

        $song = Song::find($data->song_id);

        // Check if this is not temporary playlist
        if ($data->playlist_id != 0) {
            $playlist = Playlist::find($data->playlist_id);

            if (!$playlist->songs()->find($song->id)) {
                $playlist->songs()->attach($song);
            }
        } else { // Else it is
            $temp_playlist = session()->get('temp_playlist');
            if (!$temp_playlist) {
                $temp_playlist = [
                    'id' => 0,
                    'playlist_title' => 'Danh sách tạm thời',
                    'total_songs' => 1,
                    'playlist_songs_id' => $data->song_id . ','
                ];
                echo "Iam new!";
            } else {
                $temp_playlist['total_songs']++;
                $temp_playlist['playlist_songs_id'] .= $data->song_id . ',';
                echo "UPDATE!";
            }
            session()->put('temp_playlist', $temp_playlist);
        }
        echo session()->get('temp_playlist')['playlist_songs_id'];
        echo 'Done!';

//        echo()->test);
    }

    public function importPlaylistToPlaylist()
    {
        $data = json_decode(request()->get('data'));

        $temp_playlist = session()->get('temp_playlist');
        $user_playlist = Playlist::find($data->playlist_id);

        $temp_songs_id = explode(',', $temp_playlist['playlist_songs_id']);

        $new = 0;
        $duplicate = 0;
        foreach ($temp_songs_id as $temp_song_id) {
            if ($temp_song_id !== '') {
                if (!$user_playlist->songs()->find($temp_song_id)) {
                    $user_playlist->songs()->attach($temp_song_id);
                    $new++;
                    $user_playlist->save();
                } else {
                    $duplicate++;
                }

            }
        }

        return response()->json([
            'duplicate' => $duplicate,
            'new' => $new
        ]);
    }

    public function resetTempPlaylist(){
        session()->put('temp_playlist', '');
    }
}
