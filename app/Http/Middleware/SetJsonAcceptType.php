<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetJsonAcceptType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is for an API endpoint
        if ($request->is('api/*') || $request->wantsJson()) {
            $request->headers->set('Accept', 'application/json');
            $response = $next($request);
            $response->header('Content-Type', 'application/json');

            return $response;
        }

        // For non-API requests, pass it along to the next middleware or handler
        return $next($request);
    }
}
