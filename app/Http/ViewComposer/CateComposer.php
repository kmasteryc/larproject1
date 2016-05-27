<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 5/26/16
 * Time: 1:47 PM
 */

namespace App\Http\ViewComposer;

use Illuminate\View\View;

class CateComposer
{
	public function compose(View $view){
		$view->with('cates',\App\Cate::all());
	}
}