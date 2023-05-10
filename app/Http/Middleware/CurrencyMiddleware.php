<?php
/**
 * Created by PhpStorm.

 * Date: 10.09.2018
 * Time: 14:25
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CurrencyMiddleware extends \Torann\Currency\Middleware\CurrencyMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Don't redirect the console
        if ($this->runningInConsole()) {
            return $next($request);
        }
        $currency = $request->get('currency');

        if ($currency) {
            if (in_array($currency, array_keys(currency()->getCurrencies()))
                && currency()->isActive($currency) === true) {
                $this->setUserCurrency($currency, $request);
                $redirectUrl = $request->url();
                return redirect($redirectUrl, 301);
            }
        }

        return $next($request);
    }

    /**
     * Determine if the application is running in the console.
     *
     * @return bool
     */
    private function runningInConsole()
    {
        return app()->runningInConsole();
    }

    /**
     * Get the user selected currency.
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function getUserCurrency(Request $request)
    {
        // Check request for currency
        $currency = $request->get('currency');
        if ($currency && currency()->isActive($currency) === true) {
            return $currency;
        }

        // Get currency from session
        $currency = $request->session()->get('currency');
        if ($currency && currency()->isActive($currency) === true) {
            return $currency;
        }

        return config('currency.default');
    }

    /**
     * Get the application default currency.
     *
     * @return string
     */
    protected function getDefaultCurrency()
    {
        return currency()->config('default');
    }

    /**
     * Set the user currency.
     *
     * @param string $currency
     * @param Request $request
     *
     * @return string
     */
    private function setUserCurrency($currency, $request)
    {
        $currency = strtoupper($currency);

        // Set user selection globally
        currency()->setUserCurrency($currency);

        // Save it for later too!
        $request->session()->put(['currency' => $currency]);

        //change user saved currency
        if (\Auth::hasUser() && \Auth::user()->currency !== $currency) {
            $user = \Auth::user();
            $user->currency = $currency;
            $user->save();
        }

        return $currency;
    }
}
