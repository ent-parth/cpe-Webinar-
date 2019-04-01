<?php namespace Zizaco\Entrust\Middleware;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use App\Repositories\PermissionsRole;


class EntrustPermission
{
	protected $auth;

	/**
	 * Creates a new instance of the middleware.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		//dd(Auth::guard('administrator')->user());
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  Closure $next
	 * @param  $permissions
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permissions)
	{
		//setting for role and permission
		$permissionsArray = explode('|', $permissions);
		$getrole = PermissionsRole::Select('permissions.name')
									->leftJoin('permissions','permissions.id','=','permission_role.permissions_id')
									->where('user_id',Auth::guard('administrator')->user()->id)
									->whereIn('permissions.name',$permissionsArray)
									->get();
		//dd($getrole->count());
		if (!$getrole->count()) {
			abort(403);
		}

		return $next($request);
	}
}
