<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
        'driver-api' => [
//            \App\Http\Middleware\DriverAuthenticateApi::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            \App\Http\Middleware\VerifyCsrfToken::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'admin_guest' => \App\Http\Middleware\RedirectIfAdminAuthenticated::class,
        'check-permission' => \App\Http\Middleware\CheckPermission::class,
        'speaker' => \App\Http\Middleware\RedirectIfNotSpeaker::class,
        'speaker-guest' => \App\Http\Middleware\RedirectIfSpeakerAuthenticated::class,
        'company-guest' => \App\Http\Middleware\RedirectIfCompanyAuthenticated::class,
        'company' => \App\Http\Middleware\RedirectIfNotCompany::class,
		'checkClient' => \App\Http\Middleware\CheckClient::class,
        'disablepreventback' => \App\Http\Middleware\DisablePreventBack::class,
        'users-api' => \App\Http\Middleware\UserAuthenticateApi::class,
		
		'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
		'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
		'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,
    ];
}