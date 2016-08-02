<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Playlist;
use App\Http\Requests;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request){
        return view('users.index', [
            'cp' => true
        ]);
    }
    public function index_playlist()
    {
        $playlists = Playlist::where('user_id',auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        return view('users.playlist_index', [
            'myjs' => ['jquery.dynatable.js'],
            'mycss' => ['jquery.dynatable.css'],
            'playlists' => $playlists,
            'cp'=>true
        ]);
    }
    public function create_playlist()
    {
        return view('playlists.create', [
            'myjs' => ['playlists/create.js'],
        ]);
    }
    public function edit_playlist(Playlist $playlist)
    {
        if ($playlist->user_id != auth()->user()->id){
            session()->flash('my_errors','Bạn không có quyền truy cập Danh sách nhạc của người khác!');
            return redirect('user/playlist');
        }
        return view('playlists.edit', [
            'myjs' => ['playlists/create.js'],
            'playlist' => $playlist,
            'cp' => true
        ]);
    }
}
