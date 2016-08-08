<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Nation;

use App\Http\Requests\Nations\StoreRequest;
use App\Http\Requests\Nations\UpdateRequest;

class NationController extends Controller
{
    public function index()
    {
        return view('nations.index',[
            'nations'=>Nation::all(),
            'cp' => true
        ]);
    }
    public function edit(Nation $nation)
    {
        return view ('nations.edit', [
            'nation'=> $nation,
            'cp' => true
        ]);
    }
    public function store(StoreRequest $request)
    {
        $nation = new Nation;
        $nation->id = $request->id;
        $nation->nation_title = $request->nation_title;
        $nation->save();
        return back();
    }
    public function update(UpdateRequest $request, Nation $nation)
    {
        $nation->id = $request->id;
        $nation->nation_title = $request->nation_title;
        $nation->save();
        return redirect(url('nation'));
    }
    public function delete(Nation $nation)
    {
        $nation->delete();
        return redirect(url('nation'));
    }
}
