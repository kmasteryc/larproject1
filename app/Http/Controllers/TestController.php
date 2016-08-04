<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 04/08/2016
 * Time: 15:56
 */
namespace App\Http\Controllers;
use Cache;
class TestController extends Controller{
    public function index(){
        Cache::put('test','CACHED OK?????', 100);
        echo Cache::get('test');
    }
}