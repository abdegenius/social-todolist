<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(Request $request): void
    {
        // $this->registerPolicies();

        // $publicRoutes = ['api/register', 'api/login'];

        // if (!in_array($request->path(), $publicRoutes)) {
        //     Auth::viaRequest('jwt', function ($request) {
        //         try {
        //             return JWTAuth::parseToken()->authenticate();
        //         } catch (\Exception $e) {
        //             throw $e;
        //         }
        //     });
        // }
    }
}
