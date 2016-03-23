<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\UsersTrait as UsersTrait;


class VerifyLogin {

    protected $except = ['login', 'logout', 'reset-password', 'facebook', 'facebook/callback'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if (!$request->ajax()) {
            if (!in_array($request->path(), $this->except)) {
                if (!Session::has('user_id')) {
                    if ($request->cookie('laravel_remember')) {
                        $cookie = $request->cookie('laravel_remember');
                        $response = \API::post('users/auth-cookie', [], ['cookie' => $cookie]);
                        if ($response['code'] == 200)
                            UsersTrait::flushSession((array) $response['data']);
                        return redirect('/admin');
                    }
                    return redirect('/login');
                }
            } elseif (Session::has('user_id') && $request->getRequestUri() == "/login") {
                return redirect('/admin');
            }
        }

        return $next($request);
    }

}
