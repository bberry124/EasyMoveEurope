<?php

namespace App\Http\Middleware;

use Closure;

class SetContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Security-Policy', "script-src 'unsafe-eval'");
        return $response;
    }
}
