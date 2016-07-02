<?php

namespace App\Http\Controllers;

use App\Cate;
use Illuminate\Http\Request;

use App\Http\Requests;

class RadioController extends Controller
{
    public function index($cate=31){
        
        return view('radios.index',[
            'myjs' => ['player2.js'],
            'api_url' => url("api/get-songs-in-cate/$cate"),
        ]);
    }
}
