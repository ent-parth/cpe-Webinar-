<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Helpers\PermissionHelper;

class CheckPermission
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        $permissions = is_array($permissions) ? $permissions : explode('|', $permissions);

        /*if (PermissionHelper::hasAccess($permissions)) {
            return $next($request);
        }*/
        
        return $next($request);
        abort(404);
    }
}
