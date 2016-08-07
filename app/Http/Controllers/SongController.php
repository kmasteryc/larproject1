<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Song;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Songs\StoreRequest;
use App\Http\Requests\Songs\UpdateRequest;

class SongController extends Controller
{
    public function show(Song $song)
    {
        $other_songs = Song::where(
            [
                ['cate_id', $song->cate->id],
                ['id', '<>', $song->id]
            ])
            ->orWhere([
                ['id', '<>', $song->id],
                ['cate_id',$song->cate->cate_parent ]
            ])
            ->inRandomOrder()->take(5)->with('artists')->get();
        
        return view('songs.show', [
            'title' => $song->song_title,
            'myjs' => ['player.js', 'songs/show.js'],
            'song' => $song,
			'other_songs' => $other_songs,
            'api_url_1' => url("api/get-song/$song->id"),
            'api_url_2' => url("api/get-nontime-lyrics/"),
        ]);

    }

    public function index()
    {
        $songs = Song::with('artists', 'cate')->orderBy('song_title')->paginate(10);
        return view('songs.index', [
            'myjs' => ['jquery.dynatable.js','songs/index.js'],
            'mycss' => ['jquery.dynatable.css'],
            'songs' => $songs,
            'cp' => true
        ]);
    }

    public function create()
    {
        return view('songs.create', [
            'myjs' => ['songs/create.js'],
            'cp' => true
        ]);
    }

    public function store(StoreRequest $request)
    {
        // Move upload file to appriciate location
        $upload_mp3 = $request->file('uploaded_mp3');
        $upload_mp3->move(base_path('public/uploads/mp3'), $upload_mp3->getClientOriginalName());

        // After uploading was done. Do insert info to DB
        $link = asset('uploads/mp3/' . $upload_mp3->getClientOriginalName());

        // Initialize new Song object to save


        // Process song_artists
        $artists = explode(',', $request->song_artists);

        $artists_obj = Artist::whereIn('id', $artists)->get();
        $i = 1;
        $artists_str = '';
        foreach ($artists_obj as $artist) {
            $artists_str .= $artist->artist_title_slug;
            if ($i != count($artists_obj)) {
                $artists_str .= '-ft-';
            }
            $i++;
        }
        $rand = substr(md5(rand(1, 999)), 0, 5);


        $song = new Song;
        $song->song_title = $request->song_title;
        $song->song_title_slug = str_slug($song->song_title) . '-' . $artists_str . '-' . $rand;
        $song->song_title_eng = str_replace('-', ' ', str_slug($song->song_title));
        $song->song_mp3 = $link;
        $song->cate_id = $request->cate_id;
        $song->save();

        /*Here i have 2 opts:
        first: $song->artists()->attach($artist)
        second: $artist->songs()->attach($song->id);*/

        foreach ($artists as $artist) {
            if ($artist != '') $song->artists()->attach($artist);
        }

        return redirect('song')->with('succeeds', 'Tao bai hat thanh cong!');
    }

    public function edit(Song $song)
    {
        return view('songs.edit', [
            'myjs' => ['songs/create.js'],
            'song' => $song,
            'cp' => true
        ]);
    }

    public function update(UpdateRequest $request, Song $song)
    {
        // If upload new file
        if ($request->hasFile('uploaded_mp3')) {
            // Remove old mp3 file
//			preg_match('/(.*).mp3/',$song->song_mp3,$name);
            preg_match('/(.*)\/(.*).mp3/', $song->song_mp3, $name);
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
        $artists = explode(',', $request->song_artists);

        $artists_obj = Artist::whereIn('id', $artists)->get();
        $i = 1;
        $artists_str = '';
        foreach ($artists_obj as $artist) {
            $artists_str .= $artist->artist_title_slug;
            if ($i != count($artists_obj)) {
                $artists_str .= '-ft-';
            }
            $i++;
        }
        $rand = substr(md5(rand(1, 999)), 0, 5);

        $song->song_title = $request->song_title;
        $song->cate_id = $request->cate_id;
        $song->song_title_slug = str_slug($song->song_title) . '-' . $artists_str . '-' . $rand;
        $song->song_title_eng = str_replace('-', ' ', str_slug($song->song_title));

        /*Here i have 2 opts:
        first: $song->artists()->attach($artist)
        second: $artist->songs()->attach($song->id);*/

        foreach ($artists as $artist) {
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

    public function ajax_search($search = '')
    {
        $result = Song::where('song_title', 'like', '%' . $search . '%')->get();
        return $result;
    }
}
