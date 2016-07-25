<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Http\Request;
use App\Cate;
use App\Playlist;
use App\Song;
use App\Http\Requests;
use Tools\Khelper;

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
//            dd($playlist);
            if (!$playlist['playlist_songs_id']) {
                return '';
            }
            $song_ids = explode(',', $playlist['playlist_songs_id']);
            $songs = Song::whereIn('id', $song_ids);
        } else {
            $playlist = Playlist::find($playlist);
            $songs = $playlist->songs();
        }

        // Use Eager loading !
        $songs_with_lyric = $songs->with([
                'lyrics' => function ($query) {
                    $query->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC');
                },
                'artists' => function ($query) {
                    $query->select('artist_title','artists.id');
                }
            ]
        )->get();

        foreach ($songs_with_lyric as $song) {

            $lyric = isset($song->lyrics[0]) ? $song->lyrics[0]->lyric_content : '';

            $res[] = [
                'song_id' => $song->id,
                'song_title' => $song->song_title,
                'song_mp3' => $song->song_mp3,
                'song_artist' => $song->artists[0]->artist_title,
                'song_artist_id' => $song->artists[0]->id,
                'song_img' => $song->song_img,
                'song_lyric' => $lyric
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

    public function getNontimeLyrics(Song $song){
        $lyric = $song->lyrics()->first();
        if (!$lyric) return '';
        return response()->json([
            'lyric_content' => preg_replace("/(<br \/>\\r\\n){3,}/","",Khelper::readbleLyric($lyric->lyric_content)),
            'lyric_user_name' => $lyric->user->name,
            'lyric_song_title' => $lyric->song->song_title
        ]);
    }

    public function getUserPlaylist($include_guest = "true")
    {
        $boo = $include_guest == 'true' ? true : false;
        return response()->json(Playlist::getUserPlaylist($boo));
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

    public function resetTempPlaylist()
    {
        session()->put('temp_playlist', '');
    }

    public function getAjaxHotSong(Cate $cate)
    {
        return $cate->songs()->paginate(15);
    }

    public function getAjaxHotPlaylist(Cate $cate)
    {
        return $cate->playlists()->paginate(5);
    }

    public function search()
    {
        $search = request()->get('search');

        $result_artists = Artist::where('artist_title', 'like', "%$search%")->select('id', 'artist_title')->take(5)->get()->toArray();
        $result_playlists = Playlist::where('playlist_title', 'like', "%$search%")->select('id', 'playlist_title')->take(5)->get()->toArray();
        $result_songs = Song::where('song_title', 'like', "%$search%")
            ->with(['artists' => function ($query) {
                $query->select('artists.id','artist_title');
            }])
            ->select('id', 'song_title')->take(5)->get()->toArray();

        return response()->json([
            'artists' => $result_artists,
            'playlists' => $result_playlists,
            'songs' => $result_songs
        ]);

    }

    public function getSongsByArtist(Artist $artist)
    {
        return $artist->songs()->paginate(3);
//        $songs = $artist->songs;
//        return response()->json($songs);
    }

    public function getAlbumsByArtist(Artist $artist)
    {
        $playlists = $artist->playlists()->where('playlist_official',1)->get();
        return response()->json($playlists);
    }
}
