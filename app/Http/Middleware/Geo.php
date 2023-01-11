<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class Geo
{
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session = session()->all();
        Log::info('GEO:', $session);
        if (!isset($session['geo']) && $location = Location::get($request->getClientIp())) {
            $locationZonesConfig = collect(config('location.currency_zones'));
            $geoCurrency = $locationZonesConfig->filter(function ($countries) use ($location) {
                return in_array($location->countryCode, $countries);

            });

            $sessionData = [
                'geo' => $location
            ];

            if (count($geoCurrency) > 0) {
                $geoCurrency = $geoCurrency->keys()->first();
                $currencyCode = strtoupper($geoCurrency);
                currency()->setUserCurrency($currencyCode);
                $sessionData['currency'] = $currencyCode;
            } else {
                $sessionData['currency'] = currency()->config('default');
            }

            $request->session()->put($sessionData);
        }

        return $next($request);
    }
}
