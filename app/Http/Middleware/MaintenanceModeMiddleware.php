<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SecuritySetting;
class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

    $setting = SecuritySetting::first();

        if (
            $setting &&
            $setting->maintenance_mode
        ) {
            return response()->view(
                'maintenance',
                [],
                503
            );
        }

  
    return $next($request);



    
    }
}
