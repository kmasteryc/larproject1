<?php

namespace App\Providers;

use App\Events\EventCateChange;
use App\Events\EventPlaylistChange;
use App\Events\EventUserPlaylistChange;
use App\Events\EventSongChange;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use Tools\Khelper;
use App\Song;
use App\Playlist;
use App\Cate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Song::saved(function(){
           event(new EventSongChange());
        });
        Song::deleted(function(){
           event(new EventSongChange());
        });
        Playlist::saved(function(){
            event(new EventPlaylistChange());
            event(new EventUserPlaylistChange());
        });
        Playlist::deleted(function(){
            event(new EventPlaylistChange());
            event(new EventUserPlaylistChange());
        });
        Cate::saved(function(){
            event(new EventCateChange());
        });
        Cate::deleted(function(){
            event(new EventCateChange());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('helper',function(){
           return Khelper::class; 
        });
    }
}
