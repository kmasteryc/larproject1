<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Guzzle\Http as GuzzleHttp;
use App\Http\Requests;
use Tools\Import;

class ImportController extends Controller
{
    public function create()
	{
		return view('imports.create');
	}
	public function store(Request $request)
	{
		$data = new Import($request->url);
		if ($data->getResults() == '')
		{
			return back()->withErrors($data->getErrors());
		}
		dd($data->getResults());
	}
}
