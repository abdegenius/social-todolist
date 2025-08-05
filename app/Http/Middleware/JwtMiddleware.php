<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->is('api/register') || $request->is('api/login')) {
            return $next($request);
        }

        try {
            $request->headers->set('Accept', 'application/json');
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Illuminate\Auth\AuthenticationException();
        }

        return $next($request);
    }
}
