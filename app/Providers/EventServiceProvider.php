<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\EventCateChange' => [
            'App\Listeners\UpdateCateCache',
        ],
        'App\Events\EventSongChange' => [
            'App\Listeners\UpdateSongCache',
            'App\Listeners\CallGenerateSearchData',
        ],
        'App\Events\EventPlaylistChange' => [
            'App\Listeners\UpdatePlaylistCache',
            'App\Listeners\CallGenerateSearchData',
        ],
        'App\Events\EventUserPlaylistChange' => [
            'App\Listeners\UpdateUserPlaylistCache',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}
