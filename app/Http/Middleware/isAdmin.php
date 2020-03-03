<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * For savekeeping we check if cur-user is guest, but this should not be able to happen
         * since the primairy route checks Auth (logged in) first, then check on is_admin
         **/
        if (Auth::guest() || !Auth::user()->isAdmin())
            return redirect(RouteServiceProvider::HOME);

        return $next($request);
    }
}
