<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests;

use App\Playlist;

class PlaylistController extends Controller
{
    public function index()
	{
		$playlists = Playlist::orderBy('updated_at','desc')->get();
		return view('playlists.index',[
			'myjs' => ['jquery.dynatable.js'],
			'mycss' => ['jquery.dynatable.css'],
			'playlists' => $playlists
		]);
	}
	public function create()
	{

		return view('playlists.create',[
			'myjs'=>['playlists/create.js']
		]);
	}
	public function store(Request $request)
	{
		$this->validate($request,[
			'playlist_title' => 'required|unique:playlists,playlist_title',
			'cate_id' => 'required|integer',
			'playlist_songs' => 'required'
		]);

		$playlist = new Playlist;

		$playlist->playlist_title = $request->playlist_title;
		$playlist->cate_id = $request->cate_id;
		$playlist->user_id = $request->user()->id;

		$playlist->save();

		$songs = explode(',',$request->playlist_songs);

		/*Here i have 2 opts:
		first: $song->artists()->attach($artist)
		second: $artist->songs()->attach($song->id);*/

		foreach ($songs as $song)
		{
			if ($song != '') $playlist->songs()->attach($song);
		}

		return back()->with('succeeds','Tao danh sach nhac thanh cong!');
	}
	public function edit(Playlist $playlist)
	{
		return view('playlists.edit', [
			'myjs'=> ['playlists/create.js'],
			'playlist' => $playlist,
		]);
	}
	public function update(Request $request, Playlist $playlist)
	{
		$this->validate($request,[
			'playlist_title' => 'required|unique:playlists,playlist_title,'.$playlist->id,
			'cate_id' => 'required|integer',
			'playlist_songs' => 'required'
		]);

		$playlist->playlist_title = $request->playlist_title;
		$playlist->cate_id = $request->cate_id;
		$playlist->user_id = $request->user()->id;

		$playlist->save();

		// Process playlist_songs
		// First we remove old song_artists
		$playlist->songs()->detach();
		$songs = explode(',',$request->playlist_songs);

		/*Here i have 2 opts:
		first: $song->artists()->attach($artist)
		second: $artist->songs()->attach($song->id);*/

		foreach ($songs as $song)
		{
			if ($song != '') $playlist->songs()->attach($song);
		}

		return back()->with('succeeds','Tao danh sach nhac thanh cong!');
	}
	public function delete(Playlist $playlist, Request $request)
	{
		if (!Gate::check('is-admin')) abort(404);

		$playlist->delete();

		$request->session()->flash('succeeds', 'Your done!');
		return back();
	}
}
