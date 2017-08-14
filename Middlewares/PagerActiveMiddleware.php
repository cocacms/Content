<?php

namespace Module\Content\Middlewares;

use Closure;

class PagerActiveMiddleware
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
        pagers_set_current(null);
        return $next($request);
    }
}
