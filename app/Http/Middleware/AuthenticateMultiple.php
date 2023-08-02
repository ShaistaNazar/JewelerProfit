<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;

class AuthenticateMultiple extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string[] $guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Check each guard individually
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                // dd($guard);
                // If any guard succeeds, allow access
                return $next($request);
            }
        }

        // Throw an authentication exception if no guard succeeds
        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}