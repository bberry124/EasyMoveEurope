<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('locale', 'en'); // Default to English if the locale is not set.

        app()->setLocale($locale);

        return $next($request);
    }
}

