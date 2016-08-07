<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cate;
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'cate_title' => 'unique:cates,cate_title|required',
            'cate_chart' => 'integer|required',
            'cate_parent' => 'integer|required'
        ]);

        Cate::create([
            'cate_title' => $request->cate_title,
            'cate_title_slug' => str_slug($request->cate_title),
            'cate_parent' => $request->cate_parent,
            'cate_chart' => $request->cate_chart
        ]);

        $request->session()->flash('succeeds', 'Your done!');

        return back();
    }

    public function show(Cate $cate)
    {

//        dd(Cache::get('user_playlists['.request()->getClientIp().']'));
        return view('cates.show', [
            'title' => 'Chủ đề ' . $cate->cate_title,
            'mycss' => ['lightslider.css'],
            'myjs' => ['lightslider.js', 'cates/show.js', 'playlists/show.js'],
            'cate' => $cate,
        ]);
    }

}
