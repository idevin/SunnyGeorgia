<?php

namespace App\Http\Middleware;

use Closure;
use URL;

class CabinetSavedLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        } elseif ($request->user() && $request->user()->locale) {
            $locale = $request->user()->locale;
            $request->session()->put('locale', $locale);
        } else {
            $locale = config('app.locale');
        }
        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
