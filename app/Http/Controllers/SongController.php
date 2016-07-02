<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Song;
use Illuminate\Support\Facades\Gate;

class SongController extends Controller
{
	public function show(Song $song)
	{

		SessionController::increase_view_song($song);

		return view('songs.show',[
			'song'=>$song,
			'myjs'=>['player2.js','songs/show.js'],
			'api_url' => url("api/get-song/$song->id"),
		]);
	}
	public function index()
	{
		$songs = Song::with('artists','cate')->get();
		return view('songs.index', [
			'myjs' => ['jquery.dynatable.js'],
			'mycss' => ['jquery.dynatable.css'],
			'songs' => $songs,
			'cp' => true
		]);
	}

	public function create()
	{
		return view('songs.create',[
			'myjs'=> ['songs/create.js'],
			'cp' => true
		]);
	}

	public function store(Request $request)
	{
		// Validate required field
		$this->validate($request, [
			'song_title' => 'required|unique:songs,song_title',
			'uploaded_mp3' => 'mimetypes:audio/mpeg',
			'cate_id' => 'required|integer',
			'song_artists' => 'required'
		]);

		// Move upload file to appriciate location
		$upload_mp3 = $request->file('uploaded_mp3');
		$upload_mp3->move(base_path('public/uploads/mp3'), $upload_mp3->getClientOriginalName());

		// After uploading was done. Do insert info to DB
		$link = asset('uploads/mp3/' . $upload_mp3->getClientOriginalName());

		// Initialize new Song object to save

		$song = new Song;
		$song->song_title = $request->song_title;
		$song->song_mp3 = $link;
		$song->cate_id = $request->cate_id;
		$song->save();

		// Process song_artists
		$artists = explode(',',$request->song_artists);

		/*Here i have 2 opts:
		first: $song->artists()->attach($artist)
		second: $artist->songs()->attach($song->id);*/

		foreach ($artists as $artist)
		{
			if ($artist != '') $song->artists()->attach($artist);
		}

		return redirect('song')->with('succeeds', 'Tao bai hat thanh cong!');
	}

	public function edit(Song $song)
	{
		return view('songs.edit', [
			'myjs'=> ['songs/create.js'],
			'song' => $song,
			'cp' => true
		]);
	}

	public function update(Request $request, Song $song)
	{
		$this->validate($request, [
			'song_title' => "required|unique:songs,song_title,$song->id,id",
			'uploaded_mp3' => 'mimetypes:audio/mpeg',
			'cate_id' => 'required|integer',
			'song_artists' => 'required'
		]);

		$song->song_title = $request->song_title;
		$song->cate_id = $request->cate_id;

		// If upload new file
		if ($request->hasFile('uploaded_mp3'))
		{
			// Remove old mp3 file
//			preg_match('/(.*).mp3/',$song->song_mp3,$name);
			preg_match('/(.*)\/(.*).mp3/',$song->song_mp3,$name);
			@unlink(public_path("uploads/mp3/$name[2].mp3"));

			// Move upload file to appriciate location
			$upload_mp3 = $request->file('uploaded_mp3');
			$upload_mp3->move(base_path('public/uploads/mp3'), $upload_mp3->getClientOriginalName());

			// After uploading was done. Do insert info to DB
			$link = asset('uploads/mp3/' . $upload_mp3->getClientOriginalName());
			$song->song_mp3 = $link;
		}

		// Process song_artists
		// First we remove old song_artists
		$song->artists()->detach();

		// Then process new song_artists
		$artists = explode(',',$request->song_artists);

		/*Here i have 2 opts:
		first: $song->artists()->attach($artist)
		second: $artist->songs()->attach($song->id);*/

		foreach ($artists as $artist)
		{
			if ($artist != '') $song->artists()->attach($artist);
		}

		$song->save();

		return back()->with('succeeds', 'Cap nhat bai hat thanh cong!');
	}

	public function delete(Song $song, Request $request)
	{
		if (!Gate::check('is-admin')) abort(404);

		$song->delete();

		$request->session()->flash('succeeds', 'Your done!');
		return back();
	}

	public function ajax_search($search='')
	{
		$result = Song::where('song_title','like','%'.$search.'%')->get();
		return $result;
	}
}
