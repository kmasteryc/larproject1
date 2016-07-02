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
				'layouts.app','imports.create',
				'users.playlist_create','users.playlist_edit','users.playlist_index',

			],
			'App\Http\ViewComposer\CateComposer');
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
