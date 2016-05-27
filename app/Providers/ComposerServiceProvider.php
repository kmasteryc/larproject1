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
			['songs.*'],
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
