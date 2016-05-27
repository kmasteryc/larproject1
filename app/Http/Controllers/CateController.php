<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cate;

use Gate;

class CateController extends Controller
{
	public function index()
	{
		return view('cates.index', ['cates' => Cate::all()]);
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
			'cate' => $cate
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
}
