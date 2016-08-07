<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('home')->withErrors('Bạn không có quyền để truy cập vào khu vực này!');
        }

        if ($request->user()->level != 2) {
            return redirect()->route('home')->withErrors('Bạn không có quyền để truy cập vào khu vực này!');
        }

        return $next($request);
    }
}
