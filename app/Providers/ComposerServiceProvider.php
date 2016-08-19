<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Tools\Menu;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		view()->composer(
			[
				'songs.edit','songs.create',
				'playlists.edit','playlists.create',
				'cates.edit','cates.create',
				'layouts.app','imports.import_playlist',
				'users.playlist_create','users.playlist_edit','users.playlist_index',

			],
			'App\Http\ViewComposer\CateComposer');
		view()->composer(
			[
				'layouts.nav'
			],
			'App\Http\ViewComposer\PlaylistComposer'
		);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
