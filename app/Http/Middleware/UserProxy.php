<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProxy
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }

        if ($request->user()->can('user-proxy')) {
            if ($request->ajax()) {
               // $id = $request->header('X-USER-PROXY-ID');
                $id = $request->session()->get('user-proxy-id');
            } else {
                $id = $request->session()->get('user-proxy-id');
            }
            if (!$id) {
                return $next($request);
            }
            $user = User::query()->findOrFail($id);
            Auth::setUser($user);
        }

        return $next($request);
    }
}
