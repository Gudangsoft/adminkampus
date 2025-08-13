<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SEOMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Add security headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        return $response;
    }
}
