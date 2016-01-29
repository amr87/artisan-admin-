<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VerifyLogin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

        if ($request->getRequestUri() != "/login" && $request->getRequestUri() != "/logout") {
            if (!Session::has('user_id')) {
                return redirect('/login');
            } elseif (Session::has('user_id') && $request->getRequestUri() == "/login") {
                return redirect('/admin');
            }
        }
        return $next($request);
    }

}
