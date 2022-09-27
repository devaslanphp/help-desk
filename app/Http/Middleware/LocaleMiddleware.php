<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');
        if (
            session()->has('locale')
            && in_array(session()->get('locale'), array_keys(config('system.locales')))
        ) {
            $locale = session()->get('locale');
        } elseif (
            auth()->user()?->locale
            && in_array(auth()->user()?->locale, array_keys(config('system.locales')))
        ) {
            $locale = auth()->user()?->locale;
        }
        app()->setLocale($locale);
        return $next($request);
    }
}
