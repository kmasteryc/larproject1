<?php

namespace App\Http\Controllers;

use App\Artist;
use Cache;
use App\Cate;
use App\Playlist;
use App\Song;
use App\Chart;
use App\Http\Requests;
use Tools\Khelper;

//use Tools\Khelper;

class APIController extends Controller
{

    public function getSongsInPlaylist($playlist)
    {
        if (!($playlist instanceof Playlist)) {
            $playlist = session()->get('temp_playlist');
//            dd($playlist);
            if (!$playlist['playlist_songs_id']) {
                return '';
            }
            $song_ids = explode(',', $playlist['playlist_songs_id']);
            $songs = Song::whereIn('id', $song_ids);
        } else {
//            $playlist = Playlist::find($playlist);
            $songs = $playlist->songs();
//            $songs_in_playlist_cache_name = 'songs_in_playlist_'.$playlist->id;
//            $songs = Cache::tags(['playlist'])->get($songs_in_playlist_cache_name,function() use($playlist, $songs_in_playlist_cache_name){
//                $songs = $playlist->songs;
//                Cache::tags(['playlist'])->put($songs_in_playlist_cache_name, $songs, 5000000);
//                return $songs;
//            });
        }

        // Use Eager loading !
        $songs_with_lyric = $songs->with([
                'lyrics' => function ($query) {
                    $query->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC');
                },
                'artists' => function ($query) {
                    $query->select('artist_title', 'artists.id', 'artist_img_cover', 'artist_title_slug');
                }
            ]
        )->get();

//        dd($songs_with_lyric);
        foreach ($songs_with_lyric as $song) {

            $lyric = isset($song->lyrics[0]) ? $song->lyrics[0]->lyric_content : '';

            $res[] = [
                'song_id' => $song->id,
                'song_title' => $song->song_title,
                'song_title_slug' => $song->song_title_slug,
                'song_mp3' => $song->song_mp3,
                'artists' => $song->artists,
                'song_img' => $song->artists[0]->artist_img_cover,
                'song_lyric' => $lyric
            ];
        }
        return response()->json($res);
    }

    public function getSongsInChart($cate, $week_or_month, $index)
    {
        switch ($week_or_month):

            case 'tuan': // Default for week and otherwise
                $index = $index == '' ? Carbon::now()->subWeek(1)->weekOfYear : $index;
                $index = $index < 1 ? 1 : $index;
                $time_mode = Chart::TIME_WEEK;
                break;

            case 'thang': // Month
                $index = $index == '' ? Carbon::now()->subMonth(1)->month : $index;
                $index = $index < 1 ? 1 : $index;
                $time_mode = Chart::TIME_MONTH;
                break;

        endswitch;

        $records = Chart::get_song_records($time_mode, $cate, $index, 100);


        foreach ($records as $record) {
            $song_ids[] = $record->song_id;
        }

        $ids = implode(',', $song_ids);


        $songs = Song::whereIn('id', $song_ids)->orderByRaw("FIND_IN_SET(id, '$ids')");

        // Use Eager loading !
        $songs_with_lyric = $songs->with([
                'lyrics' => function ($query) {
                    $query->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC');
                },
                'artists' => function ($query) {
                    $query->select('artist_title', 'artists.id', 'artist_title_slug');
                }
            ]
        )->get();

        foreach ($songs_with_lyric as $song) {

            $lyric = isset($song->lyrics[0]) ? $song->lyrics[0]->lyric_content : '';

            $res[] = [
                'song_id' => $song->id,
                'song_title' => $song->song_title,
                'song_title_slug' => $song->song_title_slug,
                'song_mp3' => $song->song_mp3,
//                'song_artist' => $song->artists[0]->artist_title,
//                'song_artist_id' => $song->artists[0]->id,
////                'song_artist_id' => $song->artists[0]->id,
                'artists' => $song->artists,
                'song_img' => $song->song_img,
                'song_lyric' => $lyric
            ];
        }
        return response()->json($res);
    }

    public function getSong(Song $song)
    {

        $lyric_obj = $song->lyrics()->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC')->first();

        $res[] = [
            'song_id' => $song->id,
            'song_title' => $song->song_title,
            'song_mp3' => $song->song_mp3,
            'song_artist' => $song->song_artists_title_text,
            'song_img' => $song->artists[0]->artist_img_cover,
            'song_lyric' => $lyric_obj['lyric_content']
        ];

        return response()->json($res);
    }

    public function getNontimeLyrics(Song $song)
    {
        $res = Cache::store('apc')->tags(['song'])->get('song_' . $song->id, function () use ($song) {
            $lyric = $song->lyrics()->first();
            if (!$lyric) return '';
            $lyric_content = preg_replace("/(<br \/>\\r\\n){3,}/", "", Khelper::readbleLyric($lyric->lyric_content));
            $lyric_content = preg_replace("/(<br \/>\\r\\n){2,}/", "<br />", $lyric_content);
            $res = [
                'lyric_content' => $lyric_content,
                'lyric_user_name' => $lyric->user->name,
                'lyric_song_title' => $lyric->song->song_title
            ];
//            $res = [
//                "a" => 1,
//                "b" => 2
//            ];
            Cache::store('apc')->tags(['song'])->put('song_' . $song->id, json_encode($res), 5555555);
            return json_encode($res);
        });
        return response()->json(json_decode($res));
    }

    public function getNontimeLyrics2(Song $song)
    {
        $lyric = $song->lyrics()->first();
        if (!$lyric) return '';
        $lyric_content = preg_replace("/(<br \/>\\r\\n){3,}/", "", Khelper::readbleLyric($lyric->lyric_content));
        $lyric_content = preg_replace("/(<br \/>\\r\\n){2,}/", "<br />", $lyric_content);
        $res = [
            'lyric_content' => $lyric_content,
            'lyric_user_name' => $lyric->user->name,
            'lyric_song_title' => $lyric->song->song_title
        ];
        return response()->json($res);

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

    public function getAjaxHotSong2(Cate $cate)
    {
        $child_cates = Cate::where('cate_parent', $cate->id)
            ->orWhere('id', $cate->id)
            ->with([
                'songs' => function ($q) {
                    $q->with([
                        'artists',
                        'lyrics' => function ($qq) {
                            $qq->where('lyric_has_time', 1)->orderBy('lyric_vote', 'DESC');
                        }
                    ]);
                }])->get();

        foreach ($child_cates as $child_cate) {
            foreach ($child_cate->songs as $song) {
                $img = $song->song_img !== '' ? $song->song_img : 'http://image.mp3.zdn.vn/cover3_artist/f/b/fb32b1dce0d8487b0916284892123f79_1459843495.jpg';
                $res[] = [
                    'song_id' => $song->id,
                    'song_title' => $song->song_title,
                    'song_mp3' => $song->song_mp3,
                    'song_artist' => $song->artists->first()->artist_title,
                    'song_img' => $img,
                    'song_lyric' => $song->lyrics->first()['lyric_content']
                ];
            }
        }

//        return response()->json($res);
//        dd($cate->songs());
        return $cate->songs()->paginate(15);
    }

    public function getAjaxHotSong(Cate $cate)
    {
        $child_cates = Cate::where('cate_parent', $cate->id)
            ->orWhere('id', $cate->id)
            ->select('id')
            ->get();


        foreach ($child_cates as $child_cate) {
            $child_cate_ids[] = $child_cate->id;
        }

        $songs = Song::whereIn('cate_id', $child_cate_ids)
            ->with('artists');

        return $songs->paginate(10);
    }

    public function getAjaxHotPlaylist(Cate $cate)
    {
        $child_cates = Cate::where('cate_parent', $cate->id)
            ->orWhere('id', $cate->id)
            ->select('id')
            ->get();

        foreach ($child_cates as $child_cate) {
            $child_cate_ids[] = $child_cate->id;
        }

        $playlists = Playlist::whereIn('cate_id', $child_cate_ids)
            ->with('artist');

        return $playlists->paginate(6);
    }

    public function search()
    {
        $search = request()->get('search');
        $type = request()->get('type');

        switch ($type) {
            case 'song':
                $res = Song::where('song_title', 'like', "%$search%")
                    ->orWhere('song_title_eng', 'like', "%$search%")
                    ->with(['artists' => function ($query) {
                        $query->select('artists.id', 'artist_title');
                    }])
                    ->select('id', 'song_title')->take(5)->get()->toArray();
                break;
            case 'playlist':
                $res = Playlist::where('playlist_title', 'like', "%$search%")
                    ->orWhere('playlist_title_eng', 'like', "%$search%")
                    ->select('id', 'playlist_title')
                    ->take(5)
                    ->get()
                    ->toArray();
                break;
            case 'artist':
                $res = Artist::where('artist_title', 'like', "%$search%")
                    ->orWhere('artist_title_eng', 'like', "%$search%")
                    ->select('id', 'artist_title')
                    ->take(5)
                    ->get()
                    ->toArray();
                break;
            default:
                $res['songs'] = Song::where('song_title', 'like', "%$search%")
                    ->orWhere('song_title_eng', 'like', "%$search%")
                    ->with(['artists' => function ($query) {
                        $query->select('artists.id', 'artist_title');
                    }])
                    ->select('id', 'song_title')->take(5)->get()->toArray();
                $res['playlists'] = Playlist::where('playlist_title', 'like', "%$search%")
                    ->orWhere('playlist_title_eng', 'like', "%$search%")
                    ->select('id', 'playlist_title')
                    ->take(5)
                    ->get()
                    ->toArray();
                $res['artists'] = Artist::where('artist_title', 'like', "%$search%")
                    ->orWhere('artist_title_eng', 'like', "%$search%")
                    ->select('id', 'artist_title')
                    ->take(5)
                    ->get()
                    ->toArray();
                break;
        }

        return response()->json($res);

    }

    public function getSongsByArtist(Artist $artist)
    {
        return $artist->songs()->with('artists')->paginate(10);
//        $songs = $artist->songs;
//        return response()->json($songs);
    }

    public function getAlbumsByArtist(Artist $artist)
    {
        $playlists = $artist->playlists()->where('playlist_official', 1)->get();
        return response()->json($playlists);
    }
}
