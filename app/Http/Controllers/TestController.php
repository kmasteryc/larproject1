<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 04/08/2016
 * Time: 15:56
 */
namespace App\Http\Controllers;
use App\Artist;
use App\Playlist;
use Cache;
use GuzzleHttp\Client;
class TestController extends Controller{
    public function index(){
        $product = Product::first();
        $products = Product::where('model_id', $product->model_id)->take(12)->get();
        $remain = 12 - $products->count();
        if ($remain > 0){
            $additions = Product::where('category_id', $product->category_id)->take($remain)->get();
            $products->merge($additions);
        }
        return $products;
    }
}