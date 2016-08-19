<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
class CacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $uri = $request->getRequestUri();
	    $response = Cache::driver('file')->get($uri, function() use($next, $request, $uri){
		    $response = $next($request);
		    Cache::put($uri, $response);
		    return $response;

	    });
        return $response;

    }
}
