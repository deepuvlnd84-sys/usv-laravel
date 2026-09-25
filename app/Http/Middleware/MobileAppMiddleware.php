<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class MobileAppMiddleware
{
    /**
     * Handle an incoming request.
     * Detects if the request comes from a Capacitor/Cordova/PWA mobile app container
     * and shares $isMobileApp with all Blade views while keeping desktop web isolated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isMobileApp = false;

        // 1. Explicit query string override (?app=1 or ?mode=app)
        if ($request->has('app') || $request->get('mode') === 'app') {
            $isMobileApp = true;
            session(['is_mobile_app' => true]);
        } elseif ($request->has('web')) {
            $isMobileApp = false;
            session(['is_mobile_app' => false]);
        } elseif (session()->get('is_mobile_app') === true) {
            $isMobileApp = true;
        }

        // 2. Capacitor / Cordova / Turbo Native / Custom WebView Headers
        if ($request->hasHeader('X-Capacitor') ||
            $request->hasHeader('X-Mobile-App') ||
            $request->hasHeader('X-Requested-With') && str_contains(strtolower($request->header('X-Requested-With')), 'usv') ||
            $request->header('X-Requested-With') === 'com.unitedseniorsvellanad.app') {
            $isMobileApp = true;
        }

        // 3. Custom User-Agent Detection
        $userAgent = strtolower($request->userAgent() ?? '');
        if (str_contains($userAgent, 'usvmobileapp') ||
            str_contains($userAgent, 'capacitor') ||
            str_contains($userAgent, 'cordova') ||
            str_contains($userAgent, 'turbonative') ||
            str_contains($userAgent, 'wv')) {
            $isMobileApp = true;
        }

        // Share globally across all Blade view templates
        View::share('isMobileApp', $isMobileApp);

        return $next($request);
    }
}
