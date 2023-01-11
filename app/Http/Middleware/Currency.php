<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Currency
{
    /**
     * Handle an incoming request.
     * @param  Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guest()) {
            currency()->setUserCurrency(Auth::user()->currency);
        }

        return $next($request);
    }
}
