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

            if (!session()->has('temp_playlist')) {
                return '';
            }
            $playlist = session()->get('temp_playlist');
            $song_ids = explode(',', $playlist['playlist_songs_id']);
            $songs = Song::whereIn('id', $song_ids);
        } else {
            $songs = $playlist->songs();
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
                    $query->select('artist_title', 'artists.id', 'artist_title_slug', 'artist_img_cover');
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
                'artists' => $song->artists,
                'song_img' => $song->artists[0]->artist_img_cover,
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

    public function getNontimeLyricsWithCache(Song $song)
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

            Cache::store('apc')->tags(['song'])->put('song_' . $song->id, json_encode($res), 5555555);
            return json_encode($res);
        });
        return response()->json(json_decode($res));
    }

    public function getNontimeLyrics(Song $song)
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

        $user_playlist->songs()->detach($temp_songs_id);
        $user_playlist->songs()->attach($temp_songs_id);

        return "";
    }

    public function resetTempPlaylist()
    {
        session()->forget('temp_playlist');
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

        return $playlists->paginate(12);
    }

    public function search()
    {
        $search = request()->get('search');
        $keywords = explode(" ",$search);
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

                $res['songs'] = Song::where('song_title', 'like', "$search%")
                    ->orWhere('song_title_eng', 'like', "$search%")
                    ->orWhere(function($query) use ($keywords){
                        foreach ($keywords as $keyword)
                        {
                            $query->where('song_title', 'like', "%$keyword%")
                                ->where('song_title_eng', 'like', "%$keyword%");
                        }
                    })
                    ->with(['artists' => function ($query) {
                        $query->select('artists.id', 'artist_title');
                    }])
                    ->select('id', 'song_title')->take(5)->get()->toArray();

                $res['playlists'] = Playlist::where('playlist_title', 'like', "$search%")
                    ->orWhere('playlist_title_eng', 'like', "$search%")
                    ->orWhere(function($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where('playlist_title', 'like', "%$keyword%")
                                ->where('playlist_title_eng', 'like', "%$keyword%");
                        }
                    })
                    ->select('id', 'playlist_title')
                    ->take(5)
                    ->get()
                    ->toArray();

                $res['artists'] = Artist::where('artist_title', 'like', "%$search%")
                    ->orWhere('artist_title_eng', 'like', "%$search%")
                    ->orWhere(function($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where('artist_title', 'like', "%$keyword%")
                                ->where('artist_title_eng', 'like', "%$keyword%");
                        }
                    })
                    ->select('id', 'artist_title')
                    ->take(5)
                    ->get()
                    ->toArray();
                break;
        }

        return response()->json($res);

    }

    public function test(){
        $json = file_get_contents(base_path().'/public/json/search_data.json');
        echo "<pre>";
        print_r(json_decode($json));
        echo "</pre>";
//        return response($json);
    }
    public function getSongsByArtist(Artist $artist)
    {
        return $artist->songs()->with('artists')->paginate(10);
    }

    public function getAlbumsByArtist(Artist $artist)
    {
        $playlists = $artist->playlists()->where('playlist_official', 1)->get();
        return response()->json($playlists);
    }
}
