<?php

namespace App\Listeners;

use App\Events\EventCateChange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Cache;

class UpdateCateCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CateChange  $event
     * @return void
     */
    public function handle(EventCateChange $event)
    {
        $cates = \App\Cate::select('id','cate_title','cate_parent','cate_chart','cate_title_slug')->get();
        Cache::put('cate',$cates, 999999);
    }
}
