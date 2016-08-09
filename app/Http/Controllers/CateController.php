<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cate;
use App\Playlist;
use App\Song;
use Gate;
use App\Http\Requests\Cates\StoreRequest;
use App\Http\Requests\Cates\UpdateRequest;


class CateController extends Controller
{
    public function __construct()
    {
        $this->middleware([]);
    }

    public function index()
    {
        return view('cates.index', [
            'cates' => Cate::all(),
            'cp' => true
        ]);
    }

    public function delete(Cate $cate)
    {
        if (!Gate::check('is-admin')) {
            abort(404);
        }
//		Delete its child
        Cate::where(['cate_parent' => $cate->id])->delete();

//		Delete itseft
        $cate->delete();
        
        return back();
    }

    public function edit(Cate $cate)
    {
        return view('cates.edit', [
            'myjs' => ['jquery.dynatable.js'],
            'mycss' => ['jquery.dynatable.css'],
            'cate' => $cate,
            'cp' => true
        ]);
    }

    public function update(UpdateRequest $request, Cate $cate)
    {;
        $cate->cate_title = $request->cate_title;
        $cate->cate_title_slug = str_slug($request->cate_title);
        $cate->cate_parent = $request->cate_parent;
        $cate->cate_chart = $request->cate_chart;

        $cate->save();
        $request->session()->flash('succeeds', 'Your done!');

        return back();
    }

    public function store(StoreRequest $request)
    {
        Cate::create([
            'cate_title' => $request->cate_title,
            'cate_title_slug' => str_slug($request->cate_title),
            'cate_parent' => $request->cate_parent,
            'cate_chart' => $request->cate_chart
        ]);

        $request->session()->flash('succeeds', 'Your done!');

        return back();
    }

    public function showSong(Cate $cate)
    {
        $child_cates = Cate::where('cate_parent', $cate->id)
            ->orWhere('id', $cate->id)
            ->select('id')
            ->get();

        foreach ($child_cates as $child_cate) {
            $child_cate_ids[] = $child_cate->id;
        }

        $songs = Song::whereIn('cate_id', $child_cate_ids)
            ->with('artists','views')->paginate(20);

        return view('cates.show_song', [
            'title' => 'Chủ đề ' . $cate->cate_title,
            'myjs' => ['playlists/show.js'],
            'hot_songs' => $songs,
            'cate' => $cate,
        ]);
    }

    public function showAlbum(Cate $cate, $type='album')
    {
        $child_cates = Cate::where('cate_parent', $cate->id)
            ->orWhere('id', $cate->id)
            ->select('id')
            ->get();

        foreach ($child_cates as $child_cate) {
            $child_cate_ids[] = $child_cate->id;
        }

        $playlists = Playlist::whereIn('cate_id', $child_cate_ids)
            ->with('artist')->paginate(18);

        return view('cates.show_album', [
            'title' => 'Chủ đề ' . $cate->cate_title,
            'hot_playlists' => $playlists,
            'cate' => $cate,
        ]);
    }
}
