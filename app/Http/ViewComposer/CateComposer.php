<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 5/26/16
 * Time: 1:47 PM
 */

namespace App\Http\ViewComposer;

use Illuminate\View\View;
use Cache;
class CateComposer
{
	public function compose(View $view){
//        $cates = Cache::get('cate',function(){
            $cates = \App\Cate::select('id','cate_title','cate_parent','cate_chart','cate_title_slug')->get();
//            Cache::put('cate',$cates, 999999);
//            return $cates;
//        });
		$view->with('cates', $cates);
	}
}