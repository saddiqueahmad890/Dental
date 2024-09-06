<?php

namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    public function handle($request, Closure $next)
    {
        if (! $request->expectsJson()) {
            //echo "<h1>Text from MiddleWare</h1>";
            if ($request->age && $request->age<18 ){
                return redirect('noaccess');
            }
            return $next($request);
        }
    }
}
