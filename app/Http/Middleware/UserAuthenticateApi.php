<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class UserAuthenticateApi
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
        //If request does not comes from logged in seller
        //then he shall be redirected to Seller Login page
        Auth::shouldUse('api');
        $response = null;
        $apiResponse = new \App\Http\Response\APIResponse();
        try {
            $user = JWTAuth::parseToken()->authenticate();
			//echo '<pre>'; print_r($user); die;
            if (!empty($user)) {
                $response = $next($request);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
            $response = $apiResponse->respondUnauthorized("Black listed token added. Please login again");
        	echo '<pre>'; print_r($response); die;
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $newToken = auth()->refresh(true, true);
            $data  = [
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ];
            $response = $apiResponse->respondWithError("Your token was expired please find Refreshed token", null, $data);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			//auth()->invalidate(true);
            $response = $apiResponse->respondUnauthorized("Invalid token pass. Please login again");
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
			//auth()->invalidate(true);
            $response = $apiResponse->respondUnauthorized("Unauthorized token added. Please login again");
        /*}catch (QueryException $ex){
            return $apiResponse->respondUnauthorized("jwt.token_unauthorized");

        }catch (\Exception $ex){
            return $apiResponse->respondUnauthorized("jwt.token_unauthorized");*/
        }
        return $response;
    }
}
