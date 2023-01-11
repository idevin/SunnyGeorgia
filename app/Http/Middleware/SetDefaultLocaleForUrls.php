<?php

namespace App\Http\Middleware;

use App\Language;
use Closure;
use URL;

class SetDefaultLocaleForUrls
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $langs = \Cache::rememberForever('app:languages', function () {
            return Language::all();
        });
        $locales = $langs->pluck('iso_code')->toArray();

        $urlLocale = strtolower($request->segment(1));
        $locale = $urlLocale === 'ka' ? 'ge' : $urlLocale;

        if (!empty($locale) && in_array($urlLocale, $locales)) {
            app()->setLocale($locale);
            URL::defaults(['locale' => $urlLocale]);
        } elseif (!empty($locale) && $locale == 'ge') {

            //redirecting ka to ge
            $locale = 'ka';
            return $this->redirectTo($locale, 301);
        } else {
//            $locale = app()->getLocale();
//            return $this->redirectTo($locale);
            abort(404);
        }

        return $next($request);
    }

    public function redirectTo($locale, $code = 302)
    {
        $locale = mb_strtolower($locale);
        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        $parsed = parse_url(url()->previous());
        $path = !empty($parsed['path']) ? $parsed['path'] : '/';
        \Log::info($path);
        $route = app('router')->getRoutes()->match(app('request')->create($path));
        $parametres = $route->parameters;
        $parametres['locale'] = $locale;
        $routeName = $route->getName();
        $newPath = route($routeName, $parametres);
        $newPath .= !empty($parsed['query']) ? '?' . $parsed['query'] : null;
        return redirect($newPath, $code);
    }
}
