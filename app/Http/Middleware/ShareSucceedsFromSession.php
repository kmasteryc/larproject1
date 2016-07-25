<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ShareSucceedsFromSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	protected $view;

	public function __construct(ViewFactory $view){
		$this->view = $view;
	}
    public function handle($request, Closure $next)
    {
		if ($request->session()->get('succeeds')) {
			$this->view->share('succeeds', $request->session()->get('succeeds'));
		}
        return $next($request);
    }
}
