<?php

namespace App\Providers;

use App\Playlist;
use App\Artist;
use App\Song;
use App\Cate;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);

        $router->bind('playlist', function($playlist)
        {
            if (strpos($playlist,'.html') > 0) {
                $playlist = strstr($playlist, '.html', true);
            }
            if ($playlist === 'danh-sach-tam'){
                return $playlist;
            }
            if (is_numeric($playlist)){
                return Playlist::find($playlist);

            }else{
                return Playlist::where('playlist_title_slug',$playlist)->firstOrFail();
            }
        });

		$router->bind('cate', function ($cate){
            if (strpos($cate,'.html') > 0) {
                $cate = strstr($cate, '.html', true);
            }
			if (is_numeric($cate))
			{
				return Cate::find($cate);
			}
			return Cate::where('cate_title_slug',$cate)->firstOrFail();
		});

        $router->bind('artist', function ($artist){
            if (strpos($artist,'.html') > 0) {
                $artist = strstr($artist, '.html', true);
            }
            if (is_numeric($artist))
            {
                return Artist::find($artist);
            }
            return Artist::where('artist_title_slug',$artist)->firstOrFail();
        });

        $router->bind('song', function ($song){
            if (strpos($song,'.html') > 0) {
                $song = strstr($song, '.html', true);
            }
            if (is_numeric($song))
            {
                return Song::find($song);
            }
            return Song::where('song_title_slug',$song)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
