<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;

use Closure;

class CheckClient
{
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	public function handle($request, Closure $next){  
		$current_url_client = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
       	if (Session::has('mycpa_client_id')) {
			if((strpos($current_url_client,'login') !== false) ||  (strpos($current_url_client,'register') !== false) || (strpos($current_url_client,'forgot-password') !== false)){
			   	return redirect('/');   
		   	}else{
		  		return $next($request); 
		   	}
		   
		}else{
			if((strpos($current_url_client,'login') !== false) ||  (strpos($current_url_client,'register') !== false) || (strpos($current_url_client,'forgot-password') !== false)){
				return $next($request); 
			}else{
				
					//Session::put('startupeco_message_warning', "Please login to view this page.");
					return redirect('/register');
		   }
        }

    }
}
