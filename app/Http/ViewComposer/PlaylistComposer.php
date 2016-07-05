<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 5/26/16
 * Time: 1:47 PM
 */

namespace App\Http\ViewComposer;

use Illuminate\View\View;

class PlaylistComposer
{
	public function compose(View $view){
		$view->with('menu_playlists',\App\Playlist::getUserPlaylist(true));
	}
}