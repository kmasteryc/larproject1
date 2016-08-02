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
        return view('artists.create',[
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
            'artist_nation' => 'integer|required'
        ]);

        $artist->update($request->input());
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
            'artist_nation' => 'integer|required'
        ]);

        Artist::create($request->input());
        $request->session()->flash('succeeds', 'Your done!');
        return redirect('artist');
    }

    public function ajax_search($search = '')
    {
        $result = Artist::where('artist_title', 'like', '%' . $search . '%')->get();
        return $result;
    }

    public function show(Artist $artist){
        return view('artists.show', [
            'myjs' => ['artists/show.js'],
            'artist' => $artist,
        ]);
    }
}
