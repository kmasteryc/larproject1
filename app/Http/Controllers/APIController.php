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
        $songs = $cate->songs()->select('id','song_title','song_mp3','song_img')->get();
        foreach ($songs as $song){
            $lyric_obj = $song->lyrics()->where('lyric_has_time',1)->orderBy('lyric_vote', 'DESC')->first();
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
    public function getSongsInPlaylist(Playlist $playlist)
    {
        $songs = $playlist->songs()->select('songs.id','song_title','song_mp3','song_img')->get();
        foreach ($songs as $song){
            $lyric_obj = $song->lyrics()->where('lyric_has_time',1)->orderBy('lyric_vote', 'DESC')->first();
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
    public function getSong(Song $song){

            $lyric_obj = $song->lyrics()->where('lyric_has_time',1)->orderBy('lyric_vote', 'DESC')->first();
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
}
