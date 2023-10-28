<?php

namespace App\Http\Middleware;

use Closure;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;

class VerifyCaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $recaptcha = new ReCaptcha(config('app.recaptcha_secret_key'));
        $response = $recaptcha->setExpectedHostname($request->server('SERVER_NAME'))
            ->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$response->isSuccess()) {
            return redirect()->back()->with('error', 'reCAPTCHA verification failed.');
        }

        return $next($request);
    }
}
