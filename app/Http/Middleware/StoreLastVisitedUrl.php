<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class StoreLastVisitedUrl
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
        if ($request->user()) {
            Session::put('last_visited_url', $request->fullUrl());
        } else {
            // Store intended URL if the user is not authenticated
            Session::put('intended_url', $request->fullUrl());
        }

        return $next($request);
    }
}
