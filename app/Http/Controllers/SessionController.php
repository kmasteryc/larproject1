<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SessionController extends Controller
{
    public function index()
    {
        echo 'Session controller!';
    }
    public function set(Request $request, $k, $v)
    {
//        $json = json_decode($json);
//        foreach ($json as $k=>$v)
//        {
//            $request->session()->put($k,$v);
//        }
        $request->session()->put($k,$v);
        echo "Set $k to ".$request->session()->get($k);
    }
}
