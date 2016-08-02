<?php

namespace App\Http\Controllers;

use App\Playlist;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cate;

use Gate;

class CateController extends Controller
{
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

	public function update(Request $request, Cate $cate)
	{
		$this->validate($request,[
			'cate_title' => 'required|unique:cates,cate_title,'.$cate->id
		]);
		$cate->update($request->input());
		$request->session()->flash('succeeds','Your done!');
		return back();
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'cate_title' => 'unique:cates,cate_title|required',
			'cate_parent' => 'integer|required'
		]);

		Cate::create([
			'cate_title' => $request->cate_title,
			'cate_parent' => $request->cate_parent
		]);


		$request->session()->flash('succeeds','Your done!');
		return back();
	}

	public function show(Cate $cate){

        $need_id[] = $cate->id;

        $child = $cate->where('cate_parent',$cate->id)->select('id')->get();

        foreach ($child as $ch)
        {
            $need_id[] = $ch->id;
        }

        $playlists = Playlist::whereIn('cate_id',$need_id)->orderby('created_at','DESC')->with('image','user')->take(10)->get();
        
		return view('cates.show', [
			'mycss' => ['lightslider.css'],
			'myjs' => ['lightslider.js','cates/show.js'],
			'cate' => $cate,
			'playlists' => $playlists,
		]);
	}
}
