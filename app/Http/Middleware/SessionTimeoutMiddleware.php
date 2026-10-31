<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SecuritySetting;
use Illuminate\Support\Facades\Config;
class SessionTimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

     $setting = SecuritySetting::first();

        if ($setting && $setting->session_timeout > 0) {

            Config::set(
                'session.lifetime',
                $setting->session_timeout
            );
        }

        return $next($request);
    }
}
