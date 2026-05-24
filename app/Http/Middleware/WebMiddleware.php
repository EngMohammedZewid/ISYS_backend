<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!$request->is('api/*')) {
            // Check if the user is authenticated
            if (auth('employee')->check()) {
                // If the user is authenticated, allow the request to proceed
                return $next($request);
            }

            // If the user is not authenticated, redirect to the login page
            return redirect()->route('login-web')->with('error', 'Invalid credentials');
        }

        // If the request is for an API route, allow it to proceed
        return $next($request);
    }
}
