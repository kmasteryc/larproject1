<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Artist;
use Illuminate\Support\Facades\Gate;

class ArtistController extends Controller
{
    public function index()
    {
        return view('artists.index', [
            'myjs' => ['jquery.dynatable.js'],
            'mycss' => ['jquery.dynatable.css'],
            'artists' => Artist::all(),
            'cp' => true
        ]);
    }

    public function delete(Artist $artist, Request $request)
    {
        if (!Gate::check('is-admin')) abort(404);

        $artist->delete();

        $request->session()->flash('succeeds', 'Your done!');
        return back();
    }

    public function create()
    {
        return view('artists.create', [
            'cp' => true
        ]);
    }

    public function edit(Artist $artist)
    {
        return view('artists.edit', [
            'myjs' => ['jquery.dynatable.js'],
            'mycss' => ['jquery.dynatable.css'],
            'artist' => $artist,
            'cp' => true
        ]);
    }

    public function update(Request $request, Artist $artist)
    {
        $this->validate($request, [
            'artist_title' => 'string|required|unique:artists,artist_title,' . $artist->id,
            'artist_name' => 'string|required|unique:artists,artist_name,' . $artist->id,
            'artist_info' => 'string|required|min:10',
            'artist_birthday' => 'required',
            'artist_gender' => 'integer|required',
            'artist_nation' => 'integer|required',
            'artist_img_small' => 'image',
            'artist_img_cover' => 'image'
        ]);

        $artist->artist_title = $request->input('artist_title');
        $artist->artist_title_slug = str_slug($artist->artist_title);
        $artist->artist_title_eng = str_replace('-',' ',$artist->artist_title_slug);
        $artist->artist_name = $request->input('artist_name');
        $artist->artist_info = $request->input('artist_info');
        $artist->artist_birthday = $request->input('artist_birthday');
        $artist->artist_gender = $request->input('artist_gender');
        $artist->artist_nation = $request->input('artist_nation');


        if ($request->hasFile('artist_img_small')) {
            //Remove old img
            @unlink(base_path('public/uploads/imgs/artists/'.basename($artist->artist_img_small)));

            $artist_img_small = $request->file('artist_img_small');
            $artist_img_small_name = rand(1,99999999).$artist_img_small->getClientOriginalName();
            $artist_img_small->move(base_path('public/uploads/imgs/artists/'), $artist_img_small_name);
            $artist_img_small_link = asset('uploads/imgs/artists/' . $artist_img_small_name);
            $artist->artist_img_small = $artist_img_small_link;
        }

        // After uploading was done. Do insert info to DB

        if ($request->hasFile('artist_img_cover')) {
            //Remove old img
            @unlink(base_path('public/uploads/imgs/artists/'.basename($artist->artist_img_cover)));

            $artist_img_cover = $request->file('artist_img_cover');
            $artist_img_cover_name = rand(1,99999999).$artist_img_cover->getClientOriginalName();
            $artist_img_cover->move(base_path('public/uploads/imgs/artists/'), $artist_img_cover_name);
            $artist_img_cover_link = asset('uploads/imgs/artists/' . $artist_img_cover_name);
            $artist->artist_img_cover = $artist_img_cover_link;
        }

        $artist->save();
        $request->session()->flash('succeeds', 'Your done!');
        return back();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'artist_title' => 'string|required|unique:artists',
            'artist_name' => 'string|required|unique:artists',
            'artist_info' => 'string|required|min:10',
            'artist_birthday' => 'required',
            'artist_gender' => 'integer|required',
            'artist_nation' => 'integer|required',
            'artist_img_small' => 'required|mimetypes:image/jpeg,image/png',
            'artist_img_cover' => 'required|mimetypes:image/jpeg,image/png'
        ]);

//        if (!$request->file('artist_img_small')->isValid() || $request->file('artist_img_cover')->isValid()){
//            return back()->withErrors('Upload Images Error!');
//        }

        $artist_img_small = $request->file('artist_img_small');
        $artist_img_cover = $request->file('artist_img_cover');
        $artist_img_small_name = rand(1,99999999).$artist_img_small->getClientOriginalName();
        $artist_img_cover_name = rand(1,99999999).$artist_img_cover->getClientOriginalName();
        $artist_img_small->move(base_path('public/uploads/imgs/artists/'), $artist_img_small_name);
        $artist_img_cover->move(base_path('public/uploads/imgs/artists/'), $artist_img_cover_name);

        // After uploading was done. Do insert info to DB
        $artist_img_small_link = asset('uploads/imgs/artists/' . $artist_img_small_name);
        $artist_img_cover_link = asset('uploads/imgs/artists/' . $artist_img_cover_name);

        $artist = new Artist;

        $artist->artist_title = $request->input('artist_title');
        $artist->artist_title_slug = str_slug($artist->artist_title);
        $artist->artist_title_eng = str_replace('-',' ',$artist->artist_title_slug);
        $artist->artist_name = $request->input('artist_name');
        $artist->artist_info = $request->input('artist_info');
        $artist->artist_birthday = $request->input('artist_birthday');
        $artist->artist_gender = $request->input('artist_gender');
        $artist->artist_nation = $request->input('artist_nation');
        $artist->artist_img_small = $artist_img_small_link;
        $artist->artist_img_cover = $artist_img_cover_link;

        $artist->save();
        $request->session()->flash('succeeds', 'Your done!');
        return redirect('artist');
    }

    public function ajax_search($search = '')
    {
        $result = Artist::where('artist_title', 'like', '%' . $search . '%')->get();
        return $result;
    }

    public function show(Artist $artist)
    {
        $playlists = $artist->playlists;
        return view('artists.show', [
            'playlists' => $playlists,
            'myjs' => ['artists/show.js'],
            'artist' => $artist,
        ]);
    }
}
