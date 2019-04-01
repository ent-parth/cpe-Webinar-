<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfAdminAuthenticated
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
        //If request comes from logged in seller, he will
        //be redirected to seller's home page.
        if (Auth::guard('administrator')->check()) {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
