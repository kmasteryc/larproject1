<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Artist;
use App\Lyric;
use App\Song;
use App\View;

use App\Http\Requests\Songs\StoreRequest;
use App\Http\Requests\Songs\UpdateRequest;

/**
 * Class SongController
 * @package App\Http\Controllers
 */
class SongController extends Controller
{
    /**
     * @param Lyric $lyric
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editLyric(Lyric $lyric){
        return view('songs.edit_lyric',[
            'song' => $lyric->song,
            'lyric' => $lyric,
            'cp' => true
        ]);
    }

    /**
     * @param Lyric $lyric
     * @param Request $request
     * @return mixed
     */
    public function updateLyric(Lyric $lyric, Request $request)
    {
        $lyric->lyric_content = $request->lyric_content;
        $lyric->lyric_has_time = $request->lyric_has_time == true ? 1 : 0;
        $lyric->save();
        return back()->withSucceeds("Edit complete!");
    }

    /**
     * @param Song $song
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createLyric(Song $song){
        if (count($song->lyric) > 0){
            return redirect(url('song/lyric/'.$song->lyric->id))->withErrors("This song already has lyric!");
        }
        return view('songs.create_lyric',[
            'song' => $song,
            'cp' => true
        ]);
    }

    /**
     * @param Song $song
     * @param Request $request
     * @return mixed
     */
    public function storeLyric(Song $song, Request $request){
        $lyric = new Lyric;
        $lyric->lyric_content = $request->lyric_content;
        $lyric->lyric_has_time = $request->lyric_has_time == true ? 1 : 0;
        $lyric->user_id = $request->user()->id;
        $lyric->song_id = $song->id;
        $song->lyric()->save($lyric);
        return redirect(url('song/lyric/'.$lyric->id))->withSucceeds("Add lyric complete!");
    }

    /**
     * @param Song $song
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Song $song)
    {
        $song->load('artists','views');

        $other_songs = Song::where(
            [
                ['cate_id', $song->cate->id],
                ['id', '<>', $song->id]
            ])
            ->orWhere([
                ['id', '<>', $song->id],
                ['cate_id',$song->cate->cate_parent ]
            ])
            ->inRandomOrder()->take(5)->with('artists','views')->get();

        return view('songs.show', [
            'title' => $song->song_title,
            'myjs' => ['player.js', 'songs/show.js'],
            'song' => $song,
			'other_songs' => $other_songs,
            'api_url_1' => url("api/get-song/$song->id"),
            'api_url_2' => url("api/get-nontime-lyrics/"),
        ]);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $songs = Song::with('artists', 'cate')->orderBy('id','DESC')->paginate(10);
        return view('songs.index', [
            'myjs' => ['jquery.dynatable.js','songs/index.js'],
            'mycss' => ['jquery.dynatable.css'],
            'songs' => $songs,
            'cp' => true
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('songs.create', [
            'myjs' => ['songs/create.js'],
            'cp' => true
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        // Move upload file to appriciate location
        $upload_mp3 = $request->file('uploaded_mp3');
        $upload_mp3->move(base_path('public/uploads/mp3'), $upload_mp3->getClientOriginalName());

        // After uploading was done. Do insert info to DB
        $link = asset('uploads/mp3/' . $upload_mp3->getClientOriginalName());


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

        // Process lyric
        if ($request->lyric_content != '')
        {
            $lyric = new Lyric;
            $lyric->lyric_content = $request->lyric_content;
            $lyric->lyric_has_time = $request->lyric_has_time == true ? 1 : 0;
            $lyric->user_id = $request->user()->id;
            $lyric->song_id = $song->id;
            $song->lyric()->save($lyric);
        }

        /*Here i have 2 opts:
        first: $song->artists()->attach($artist)
        second: $artist->songs()->attach($song->id);*/

        foreach ($artists as $artist) {
            if ($artist != '') $song->artists()->attach($artist);
        }

        return redirect('song')->with('succeeds', 'Tao bai hat thanh cong!');
    }

    /**
     * @param Song $song
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Song $song)
    {
        return view('songs.edit', [
            'myjs' => ['songs/create.js'],
            'song' => $song,
            'cp' => true
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Song $song
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param Song $song
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Song $song, Request $request)
    {
        if (!Gate::check('is-admin')) abort(404);

        $song->delete();

        $request->session()->flash('succeeds', 'Your done!');
        return back();
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function ajax_search($search = '')
    {
        $result = Song::where('song_title', 'like', '%' . $search . '%')->get();
        return $result;
    }
}
